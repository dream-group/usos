<?php

namespace Dream\USOS\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApplicantsController extends Controller
{
    public function get(Request $request)
    {
        $this->app['debug.dump_request']->dumpRequest();

        $email = $request->get('email', 'jmd@mimuw.edu.pl');

        $sampleData = array (
            'email' => $email,
            'basic_data' =>
                array (
                    'sex' => 'K',
                    'pesel' => '96121378241',
                    'date_of_birth' => '1996-12-13',
                    'data_source' => 'user',
                ),
            'contact_data' =>
                array (
                    'phone_number' => '+48 22 554 42 23',
                    'phone_number_type' => 'STA',
                    'phone_number2' => NULL,
                    'phone_number2_type' => NULL,
                    'official_post_code' => '05820',
                    'official_city' => 'Piastów',
                    'official_city_is_city' => 'T',
                    'official_street' => 'J. Styki',
                    'official_street_number' => '32',
                    'official_flat_number' => NULL,
                    'official_country' => 'PL',
                    'real_post_code' => NULL,
                    'real_city' => NULL,
                    'real_city_is_city' => NULL,
                    'real_street' => NULL,
                    'real_street_number' => NULL,
                    'real_flat_number' => NULL,
                    'real_country' => NULL,
                    'modification_date' => '2016-01-13T20:51:07.281784Z',
                ),
            'name' =>
                array (
                    'middle' => 'Zofia',
                    'given' => 'Janina',
                    'maiden' => NULL,
                    'family' => 'Kowalska397',
                ),
            'phone' => '+48 22 554 42 23',
            'citizenship' => 'PL',
            'id' => 30,
            'photo' => NULL,
            'photo_permission' => NULL,
            'additional_data' =>
                array (
                    'document_type' => 'C',
                    'document_number' => 'AN12345',
                    'document_exp_date' => '2017-11-14',
                    'document_country' => 'PL',
                    'city_of_birth' => 'Polska',
                    'country_of_birth' => 'PL',
                    'mother_maiden_name' => NULL,
                    'fathers_name' => NULL,
                    'mothers_name' => NULL,
                    'military_status' => NULL,
                    'military_category' => NULL,
                    'wku' => NULL,
                ),
            'education_data' =>
                array (
                    'high_school_type' => 'Liceum ogólnokształcące',
                    'high_school_name' => 'I Liceum Ogólnokształcące im. Mikołaja Kopernika',
                    'high_school_usos_code' => '16829',
                    'high_school_city' => 'Toruń',
                    'documents' =>
                        array (
                            0 =>
                                array (
                                    'certificate_type' => 'Matura zagraniczna',
                                    'certificate_type_code' => 'Z',
                                    'certificate_usos_code' => NULL,
                                    'document_number' => '123/456',
                                    'issue_date' => '2016-02-01',
                                    'issue_institution' => 'Uniwersytet Warszawski',
                                    'issue_institution_usos_code' => NULL,
                                    'issue_city' => 'Warszawa',
                                    'comment' => 'Brak komentarza',
                                    'modification_date' => '2016-02-05T22:27:47.351832Z',
                                ),
                            1 =>
                                array (
                                    'certificate_type' => 'Nowa matura',
                                    'certificate_type_code' => 'N',
                                    'certificate_usos_code' => 'N',
                                    'document_number' => 'AB123456M',
                                    'issue_date' => '2015-06-26',
                                    'issue_institution' => 'Okręgowa Komisja Egzaminacyjna - WARSZAWA',
                                    'issue_institution_usos_code' => '18250',
                                    'issue_city' => 'Warszawa',
                                    'comment' => NULL,
                                    'modification_date' => '2015-12-06T16:53:36.705397Z',
                                ),
                        ),
                ),
            'password' => 'irk1$$758011247ef2c7bc6dc34c4d2ba54a5a',
            'modification_data' => '2016-02-25T15:04:06.032501+00:00',
            'index_number' => NULL,
            'accepted_data' => 'T',
            'cas_password_overwrite' => false,
        );

        return new JsonResponse($sampleData);
    }
}
