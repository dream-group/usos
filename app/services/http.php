<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Slim\Http\Factory\DecoratedResponseFactory;
use Slim\Http\Factory\DecoratedServerRequestFactory;
use Slim\Http\Factory\DecoratedUriFactory;

use function DI\create;
use function DI\get;

return [
    // common factory
    Psr17Factory::class => create(),

    // request
    DecoratedServerRequestFactory::class => create()->constructor(get(Psr17Factory::class)),
    ServerRequestFactoryInterface::class => get(DecoratedServerRequestFactory::class),

    // response
    DecoratedResponseFactory::class => create()->constructor(get(Psr17Factory::class), get(Psr17Factory::class)),
    ResponseFactoryInterface::class => get(DecoratedResponseFactory::class),

    // uri
    DecoratedUriFactory::class => create()->constructor(get(Psr17Factory::class)),
    UriFactoryInterface::class => get(DecoratedUriFactory::class),
];
