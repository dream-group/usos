<?php

declare(strict_types=1);

namespace Dream\USOS\Controllers;

use Dream\DreamApply\Client\Exceptions\ItemNotFoundException;
use Dream\DreamApply\Client\Models\Applicant;
use Dream\USOS\Api\DreamApplyClientFactoryInterface;
use Dream\USOS\Debug\DumpRequest;
use Dream\USOS\Env;
use Dream\USOS\Models\IRKUser;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class ApplicantsController
{
    public function search(
        ServerRequest $request,
        Response $response,
        string $host,
        DreamApplyClientFactoryInterface $clientFactory,
        Env $env,
        DumpRequest $dumpRequest
    ): ResponseInterface {
        if ($env->isDebug()) {
            $dumpRequest->dumpRequest($request);
        }

        $client = $clientFactory->build($host, $request);

        $email = $request->getQueryParam('email');

        if (!$email) {
            throw new HttpBadRequestException($request, 'Request must contain "email" field');
        }

        // TODO: also filters by PESEL(?) and Surname

        $applicants = $client->applicants(['byEmails' => $email]);

        $users = [];

        foreach ($applicants as $id => $applicant) {
            /** @var Applicant $applicant */

            $users[] = new IRKUser($applicant, $id);
        }

        $responseJson = [
            'count'     => count($users),
            'next'      => null,
            'previous'  => null,
            'results'   => $users,
        ];

        return $response->withJson($responseJson);
    }

    public function show(
        ServerRequest $request,
        Response $response,
        string $host,
        int $applicantId,
        DreamApplyClientFactoryInterface $clientFactory,
        Env $env,
        DumpRequest $dumpRequest
    ) {
        if ($env->isDebug()) {
            $dumpRequest->dumpRequest($request);
        }

        $client = $clientFactory->build($host, $request);

        try {
            $applicant = $client->applicants[$applicantId];
        } catch (ItemNotFoundException $e) {
            throw new HttpBadRequestException($request, 'Applicant not found');
        }

        $irkUser = new IRKUser($applicant, $applicantId);

        return $response->withJson($irkUser);
    }
}
