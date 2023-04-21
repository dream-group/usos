<?php

declare(strict_types=1);

namespace Dream\USOS\Tests;

use DI\Container;
use Dream\USOS\Controllers\ApplicantsController;
use Dream\USOS\Env;
use Dream\USOS\Tests\Helpers\MockFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Factory\DecoratedResponseFactory;
use Slim\Http\Factory\DecoratedServerRequestFactory;

class SearchIntegrationTest extends TestCase
{
    public function testSearch(): void
    {
        /** @var Container $container */
        $container = require __DIR__ . '/../app/services.php';

        $request = $container->get(DecoratedServerRequestFactory::class)
            ->createServerRequest('get', 'http://localhost')
            ->withQueryParams([
                'email' => 'damo.of.atarneus@example.com',
            ]);

        /** @var ResponseInterface $response */
        $response = $container->call([new ApplicantsController(), 'search'], [
            'request' => $request,
            'response' => $container->get(DecoratedResponseFactory::class)->createResponse(),
            'host' => 'localhost',
            'clientFactory' => new MockFactory(),
            'env' => new Env('test'), // do not produce dev garbage
        ]);

        $result = json_decode(strval($response->getBody()), true);

        self::assertEquals([
            'count' => 1,
            'next' => null,
            'previous' => null,
            'results' => [[
                'id' => 2,
                'email' => 'damo.of.atarneus@example.com',
                'name' => [
                    'full' => 'Damo of Atarneus',
                    'given' => 'Damo',
                    'middle' => null,
                    'family' => 'of Atarneus',
                ],
                'phone' => '+372 123456789',
                'citizenship' => 'GB',
                'photo' => null,
                'photo_permission' => null,
                'password' => 'irk1$$00000000000000000000000000000000',
                'index_number' => null,
                'accepted_data' => 'T',
                'cas_password_overwrite' => false,
                'basic_data' => [],
                'contact_data' => [],
                'additional_data' => [],
                'education_data' => [],
            ]],
        ], $result);
    }
}
