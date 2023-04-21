<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Http\Factory\DecoratedResponseFactory;

use function DI\create;
use function DI\get;

return [
    // common factory
    Psr17Factory::class => create(),

    // response
    DecoratedResponseFactory::class => create()->constructor(get(Psr17Factory::class), get(Psr17Factory::class)),
    ResponseFactoryInterface::class => get(DecoratedResponseFactory::class),
];
