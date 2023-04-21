<?php

declare(strict_types=1);

use Dream\USOS\Middleware\ErrorMiddleware;

use function DI\autowire;

return [
    ErrorMiddleware::class => autowire(),
];
