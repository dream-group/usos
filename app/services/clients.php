<?php

declare(strict_types=1);

use Dream\USOS\Api\DreamApplyClientFactory;
use Dream\USOS\Api\DreamApplyClientFactoryInterface;

use function DI\autowire;
use function DI\get;

return [
    DreamApplyClientFactory::class => autowire(),
    DreamApplyClientFactoryInterface::class => get(DreamApplyClientFactory::class),
];
