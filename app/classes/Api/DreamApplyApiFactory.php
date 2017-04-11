<?php

namespace Dream\USOS\Api;

use Dream\DreamApply\Client\Client;
use Dream\USOS\Exceptions\ServiceException;
use League\Uri\Schemes\Http;
use Symfony\Component\HttpFoundation\Request;

class DreamApplyApiFactory
{
    public function get(string $host, Request $request): Client
    {
        if (checkdnsrr($host, 'a') === false && checkdnsrr($host, 'aaaa') === false) {
            throw new ServiceException("Unknown host: $host", 400);
        }

        $endpoint = Http::createFromComponents([
            'scheme'    => 'https',
            'host'      => $host,
            'path'      => '/api/',
        ]);

        $auth = $request->headers->get('authorization');

        if (preg_match('/token\s+(.+)/i', $auth, $matches) === 0) {
            throw new ServiceException("Invalid auth header: '$auth'", 400);
        }

        $token = $matches[1];

        return new Client(strval($endpoint), $token);
    }

    public function __invoke(string $host, Request $request): Client
    {
        return $this->get($host, $request);
    }
}
