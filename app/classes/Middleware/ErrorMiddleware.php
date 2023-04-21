<?php

namespace Dream\USOS\Middleware;

use Dream\DreamApply\Client\Exceptions\HttpFailResponseException;
use Dream\USOS\Controllers\Controller;
use Dream\USOS\Exceptions\ServiceException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorMiddleware extends Controller
{
    public function __invoke(\Exception $exception, Request $request, int $code): Response
    {
        $response = [
            'error'     => true,
            'message'   => Response::$statusTexts[$code] ?? 'Unknown error'
        ];

        if (
            $exception instanceof ServiceException || // this service exception
            $exception instanceof HttpFailResponseException // Dream SDK exception
        ) {
            $response['message'] = $exception->getMessage();

            $code = $exception->getCode();
        }

        if ($this->app['debug']) {
            $response['exception'] = strval($exception);
        }

        return $this->app->json($response, $code);
    }
}
