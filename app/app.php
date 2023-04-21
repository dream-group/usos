<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use Dream\USOS\Controllers\ApplicantsController;
use Dream\USOS\Middleware as m;
use Slim\Routing\RouteCollectorProxy;

$container = require __DIR__ . '/services.php';

$app = Bridge::create($container);

$app->group('/{host}', function (RouteCollectorProxy $host) {
    $host->group('/api', function (RouteCollectorProxy $api) {
        $api->group('/applicants', function (RouteCollectorProxy $applicants) {
            $applicants->get('/', [ApplicantsController::class, 'search']);
            $applicants->get('/{applicantId:\d+}/', [ApplicantsController::class, 'show']);
        });
    });
});

$app->add($container->get(m\ErrorMiddleware::class));

return $app;
