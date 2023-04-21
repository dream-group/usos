<?php

declare(strict_types=1);

namespace Dream\USOS\Controllers;

use Dream\DreamApply\Client\Exceptions\ItemNotFoundException;
use Dream\DreamApply\Client\Models\Applicant;
use Dream\USOS\Api\DreamApplyClientFactory;
use Dream\USOS\Debug\DumpRequest;
use Dream\USOS\Env;
use Dream\USOS\Exceptions\ServiceException;
use Dream\USOS\Models\IRKUser;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ApplicantsController
{
    public function search(
        ServerRequest $request,
        Response $response,
        string $host,
        DreamApplyClientFactory $clientFactory,
        Env $env,
        DumpRequest $dumpRequest
    ): ResponseInterface {
        if ($env->isDebug()) {
            $dumpRequest->dumpRequest($request);
        }

        $client = $clientFactory->get($host, $request);

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

    public function show(Request $request, string $host, int $applicantId)
    {
        if ($this->app['debug']) {
            $this->app['debug.dump_request']->dumpRequest();
        }

        $client = $this->app['factory.dreamapply.api']->get($host, $request);

        try {
            $applicant = $client->applicants[$applicantId];
        } catch (ItemNotFoundException $e) {
            throw new ServiceException('Applicant not found', SymfonyResponse::HTTP_NOT_FOUND);
        }

        $irkUser = new IRKUser($applicant, $applicantId);

        return $this->app->json($irkUser);
    }
}
