<?php

declare(strict_types=1);

namespace Dream\USOS\Api;

use Dream\Apply\Client\Client;
use Slim\Exception\HttpBadRequestException;
use Slim\Http\Factory\DecoratedUriFactory;
use Slim\Http\ServerRequest;

final class DreamApplyClientFactory implements DreamApplyClientFactoryInterface
{
    /** @var DecoratedUriFactory */
    private $uriFactory;

    public function __construct(DecoratedUriFactory $uriFactory)
    {
        $this->uriFactory = $uriFactory;
    }

    public function build(string $host, ServerRequest $request): Client
    {
        if (checkdnsrr($host, 'a') === false && checkdnsrr($host, 'aaaa') === false) {
            throw new HttpBadRequestException($request, "Unknown host: $host");
        }

        $endpoint = $this->uriFactory->createUri()
            ->withScheme('https')
            ->withHost($host)
            ->withPath('/api/')
        ;

        $auth = $request->getHeaderLine('authorization');

        if (preg_match('/token\s+(.+)/i', $auth, $matches) === 0) {
            throw new HttpBadRequestException($request, "Invalid auth header: '$auth'");
        }

        $token = $matches[1];

        return new Client(strval($endpoint), $token);
    }
}
