<?php

declare(strict_types=1);

namespace Dream\USOS\Middleware;

use Dream\Apply\Client\Exceptions\HttpFailResponseException;
use Dream\USOS\Env;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Slim\Http\Factory\DecoratedResponseFactory;

final class ErrorMiddleware implements MiddlewareInterface
{
    /** @var Env */
    private $env;
    /** @var DecoratedResponseFactory */
    private $responseFactory;

    public function __construct(Env $env, DecoratedResponseFactory $responseFactory)
    {
        $this->env = $env;
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $code = 500;
            $responseJson = [
                'error'     => true,
                'message'   => 'Unknown error',
            ];

            if (
                $exception instanceof HttpException || // slim exception
                $exception instanceof HttpFailResponseException // Dream SDK exception
            ) {
                $responseJson['message'] = $exception->getMessage();
                $code = $exception->getCode();
            }

            if ($this->env->isDebug()) {
                $responseJson['exception'] = strval($exception);
            }

            return $this->responseFactory->createResponse($code)->withJson($responseJson);
        }
    }
}
