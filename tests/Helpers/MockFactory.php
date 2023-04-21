<?php

namespace Dream\USOS\Tests\Helpers;

use Dream\DreamApply\Client\Client;
use Dream\USOS\Api\DreamApplyClientFactoryInterface;
use Slim\Http\ServerRequest;

class MockFactory implements DreamApplyClientFactoryInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client('', '');
        \Closure::bind(function () {
            $this->http = new MockHttpHelper();
        }, $this->client, $this->client)();
    }

    /**
     * Fake factory
     */
    public function build(string $host, ServerRequest $request): Client
    {
        return $this->client;
    }
}
