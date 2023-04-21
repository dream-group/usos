<?php

namespace Dream\USOS\Tests\Helpers;

use Dream\DreamApply\Client\Client;

class MockFactory
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
    public function get()
    {
        return $this->client;
    }
}
