<?php

declare(strict_types=1);

use Dream\USOS\Api\DreamApplyClientFactory;

use function DI\create;

return [
    DreamApplyClientFactory::class => create(),
];
