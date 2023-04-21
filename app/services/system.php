<?php

declare(strict_types=1);

use Dream\USOS\Debug\DumpRequest;
use Dream\USOS\Env;

use function DI\create;
use function DI\env;

return [
    Env::class => create()->constructor(env('APP_ENV')),
    DumpRequest::class => create()->constructor(__DIR__ . '/../../data'),
];
