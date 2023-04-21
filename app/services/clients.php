<?php

declare(strict_types=1);

use Dream\USOS\Api\DreamApplyClientFactory;
use Dream\USOS\Api\DreamApplyClientFactoryInterface;

use function DI\create;
use function DI\get;

return [
    DreamApplyClientFactory::class => create(),
    DreamApplyClientFactoryInterface::class => get(DreamApplyClientFactory::class),
];
