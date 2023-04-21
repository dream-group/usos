<?php

namespace Dream\USOS\Tests\Helpers;

use Psr\Http\Message\ResponseInterface;

class MockHttpHelper
{
    public function getJson($url, $query = [])
    {
        if ($url === 'applicants' && $query === ['byEmails' => 'damo.of.atarneus@example.com']) {
            return [2 => [
                'id' => 2,
                'type' => 'Natural',
                'registered' => '2020-01-01T20:00:00+00:00',
                'name' =>
                    [
                        'full' => 'Damo of Atarneus',
                        'given' => 'Damo',
                        'middle' => null,
                        'family' => 'of Atarneus',
                    ],
                'email' => 'damo.of.atarneus@example.com',
                'phone' => '+372 123456789',
                'reference' => null,
                'citizenship' => 'GB',
                'applications' => '/api/v3/applicants/2/applications',
                'trackers' => '/api/v3/applicants/2/trackers',
                'photo' => '/api/v3/applicants/2/photo',
                'documents' => '/api/v3/applicants/2/documents',
                'studyplans' => '/api/v3/applicants/2/studyplans',
                'consents' => '/api/v3/applicants/2/consents',
                'invoices' => '/api/v3/applicants/2/invoices',
                'wishes' => '/api/v3/applicants/2/wishes',
            ]];
        }

        if ($url === '/api/v3/applicants/2/applications' && $query === []) {
            return [2 => [
                'id' => 2,
                'created' => '2020-01-03T12:00:00+00:00',
                'revised' => '2020-01-03T12:00:00+00:00',
                'submitted' => '2020-01-03T12:00:00+00:00',
                'status' => 'Reopened',
                'academic_term' => '/api/v3/academic-terms/13',
                'applicant' => '/api/v3/applicants/2',
                'flags' => '/api/v3/applications/2/flags',
                'courses' => '/api/v3/applications/2/courses',
                'offers' => '/api/v3/applications/2/offers',
                'exports' => '/api/v3/applications/2/exports',
                'documents' => '/api/v3/applications/2/documents',
                'studyplans' => '/api/v3/applications/2/studyplans',
                'scores' => '/api/v3/applications/2/scores',
                'pdf' => '/api/v3/applications/2/pdf',
            ]];
        }

        throw new \LogicException('No mock data for this request');
    }
}
