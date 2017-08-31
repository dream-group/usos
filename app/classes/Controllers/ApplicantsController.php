<?php

namespace Dream\USOS\Controllers;

use Dream\DreamApply\Client\Exceptions\ItemNotFoundException;
use Dream\DreamApply\Client\Models\Applicant;
use Dream\USOS\Exceptions\ServiceException;
use Dream\USOS\Models\IRKUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicantsController extends Controller
{
    public function index(Request $request, string $host): Response
    {
        if ($this->app['debug']) {
            $this->app['debug.dump_request']->dumpRequest();
        }

        $client = $this->app['factory.dreamapply.api']->get($host, $request);

        $email = $request->get('email');

        if (!$email) {
            throw new ServiceException('Request must contain "email" field', Response::HTTP_BAD_REQUEST);
        }

        // TODO: also filters by PESEL(?) and Surname

        $applicants = $client->applicants(['byEmails' => $email]);

        $users = [];

        foreach ($applicants as $id => $applicant) {
            /** @var Applicant $applicant */

            $users []= new IRKUser($applicant, $id);
        }

        $response = [
            'count'     => count($users),
            'next'      => null,
            'previous'  => null,
            'results'   => $users,
        ];

        return $this->app->json($response);
    }

    public function show(Request $request, string $host, int $applicantId)
    {
        if ($this->app['debug']) {
            $this->app['debug.dump_request']->dumpRequest();
        }

        $client = $this->app['factory.dreamapply.api']->get($host, $request);

        try {
            $applicant = $client->applicants[$applicantId];
        } catch (ItemNotFoundException $e) {
            throw new ServiceException('Applicant not found', Response::HTTP_NOT_FOUND);
        }

        $irkUser = new IRKUser($applicant, $applicantId);

        return $this->app->json($irkUser);
    }
}
