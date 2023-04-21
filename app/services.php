<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->addDefinitions(
    __DIR__ . '/services/clients.php',
    __DIR__ . '/services/http.php',
    __DIR__ . '/services/middleware.php',
    __DIR__ . '/services/system.php'
);

return $builder->build();
