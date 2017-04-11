<?php

namespace Dream\USOS\Controllers;

use Dream\DreamApply\Client\Models\Applicant;
use Symfony\Component\HttpFoundation\{
    JsonResponse, Request, Response
};

class ApplicantsController extends Controller
{
    public function get(Request $request, string $host): Response
    {
        if ($this->app['debug']) {
            $this->app['debug.dump_request']->dumpRequest();
        }

        $client = $this->app['factory.dreamapply.api']($host, $request);

        $email = $request->get('email', 'jmd@mimuw.edu.pl'); // TODO: remove default, throw exception if no email

        $applicants = $client->applicants->filter()->toArray();

        $applicants = array_filter($applicants, function (Applicant $applicant) use ($email) {
            return $applicant->email === $email;
        });

        $users = [];

        foreach ($applicants as $applicant) {
            /** @var Applicant $applicant */

            $users []= [
                'email' => $applicant->email,
                'name'  => $applicant->name,
                'phone' => $applicant->phone,
            ];
        }

        $request = [
            'count'     => count($users),
            'next'      => null,
            'previous'  => null,
            'results'   => $users,
        ];


        return new JsonResponse($request);
    }
}
