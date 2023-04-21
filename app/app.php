<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use Dream\USOS\Middleware as m;

$container = require __DIR__ . '/services.php';

$app = Bridge::create($container);

$app->add($container->get(m\ErrorMiddleware::class));

return $app;
