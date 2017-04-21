<?php

namespace Dream\USOS\Models;

use Dream\DreamApply\Client\Models\Applicant;
use Dream\DreamApply\Client\Models\Application;

class IRKUser implements \JsonSerializable
{
    private $id;
    private $applicant;

    public function __construct(Applicant $applicant, int $id)
    {
        $this->id = $id;
        $this->applicant = $applicant;
    }

    public function toIRKArray(): array
    {
        $applicant = $this->applicant;

        $application = null;

        if (($applications = $applicant->applications->toArray())) {
            /** @var Application $application */
            $application = end($applications);
        }

        $data = [
            'id'            => $this->id,
            'email'         => $applicant->email,
            'name'          => $applicant->name, // DA structure is the same as IRK
            'phone'         => $applicant->phone,
            'citizenship'   => $applicant->citizenship,
            'accepted_data' => 'T', // leave as is
        ];

        if ($application) {
            // basic data

            $profile = $application->profile;

            $basicData = [
                'data_source' => 'user',
            ];

            if (isset($profile['gender'])) {
                $basicData['sex'] = ($application->profile['gender'] === 'M') ? 'M' : 'K'; // K = female
            }

            if (isset($profile['birth']['date'])) {
                $basicData['date_of_birth'] = $profile['birth']['date'];
            }

            if (isset($profile['nationalidcode']['polish'])) {
                $basicData['pesel'] = $profile['nationalidcode']['polish'];
            }

            $data['basic_data'] = $basicData; // always add, at least data_source is always set

            // contact data

            $contact = $application->contact;

            $contactData = [];

            if (isset($contact['telephone']['mobile'])) {
                $contactData['phone_number']        = $contact['telephone']['mobile'];
                $contactData['phone_number_type']   = 'KOM';
            }

            // todo: maybe extract evening or day to phone_number2

            if (isset($contact['address']['country'])) {
                $contactData['official_country'] = $contact['address']['country'];
            }

            if (isset($contact['address']['postalcode'])) {
                $contactData['official_post_code'] = $contact['address']['postalcode'];
            }

            // city can be in two fields

            $city = [];

            if (isset($contact['address']['municipality'])) {
                $city []= $contact['address']['municipality'];
            }

            if (isset($contact['address']['city'])) {
                $city []= $contact['address']['city'];
            }

            if (count($city) > 0) {
                $contactData['official_city'] = implode(', ', $city);
            }

            if (isset($contact['address']['street'])) {
                // supposed to be street but send the whole street address
                // we're trying not to guess the structure in the unstructured fields
                // but still send all possible data
                $contactData['official_street'] = $contact['address']['street'];
            }

            $contactData['modification_date'] = $application->revised; // first time, in contact data

            $data['contact_data'] = $contactData;

            // additional_data

            $additionalData = [];

            if (isset($profile['passport'])) {
                $additionalData['document_type']        = 'P';
                $additionalData['document_number']      = $profile['passport']['number'];
                $additionalData['document_exp_date']    = $profile['passport']['expiry'];
                $additionalData['document_country']     = $profile['passport']['country'];
            } elseif (isset($profile['idcard'])) {
                $additionalData['document_type']        = 'C';
                $additionalData['document_number']      = $profile['idcard']['number'];
                $additionalData['document_exp_date']    = $profile['idcard']['expiry'];
                $additionalData['document_country']     = $profile['idcard']['country'];
            }

            if (isset($profile['birth']['place'])) {
                $additionalData['city_of_birth'] = $profile['birth']['place'];
            }

            if (isset($profile['birth']['country'])) {
                $additionalData['country_of_birth'] = $profile['birth']['country'];
            }

            $data['modification_data'] = $application->revised; // again, in root
        }

        return $data;
    }

    public function jsonSerialize()
    {
        return $this->toIRKArray();
    }
}
