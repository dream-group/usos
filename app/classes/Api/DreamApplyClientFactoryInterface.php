<?php

declare(strict_types=1);

namespace Dream\USOS\Api;

use Dream\Apply\Client\Client;
use Slim\Http\ServerRequest;

interface DreamApplyClientFactoryInterface
{
    public function build(string $host, ServerRequest $request): Client;
}
