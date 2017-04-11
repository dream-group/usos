<?php

namespace Dream\USOS\Controllers;

use Dream\DreamApply\Client\Exceptions\HttpFailResponseException;
use Dream\USOS\Exceptions\ServiceException;
use Symfony\Component\HttpFoundation\{
    JsonResponse, Request, Response
};

class ErrorController extends Controller
{
    public function __invoke(\Exception $exception, Request $request, $code): Response
    {
        $response = [
            'error' => true,
        ];

        $headers = [];

        if ($code % 100 === 5) {
            $response['message'] = 'Internal server error';
        }

        if ($code === 404) {
            $response['message'] = 'Resource not found';
        }

        if ($code === 400) {
            $response['message'] = 'Invalid request';
        }

        if ($exception instanceof ServiceException || // this service exception
            $exception instanceof HttpFailResponseException) { // Dream SDK exception
            $response['message'] = $exception->getMessage();

            $headers['X-Status-Code'] = $exception->getCode();
        }

        if ($this->app['debug']) {
            $response['exception'] = strval($exception);
        }

        return new JsonResponse($response, 500 /* ignored in error handler */, $headers);
    }
}
