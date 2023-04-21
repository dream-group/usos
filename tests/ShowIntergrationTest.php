<?php

declare(strict_types=1);

namespace Dream\USOS\Tests;

use Dream\USOS\Controllers\ApplicantsController;
use Dream\USOS\Tests\Helpers\MockFactory;
use PHPUnit\Framework\TestCase;
use Silex\Application as Silex;
use Symfony\Component\HttpFoundation\Request;

class ShowIntergrationTest extends TestCase
{
    public function testSearch(): void
    {
        $app = new Silex();
        $app['factory.dreamapply.api'] = new MockFactory();

        $c = new ApplicantsController($app);

        $request = new Request([
            'email' => 'damo.of.atarneus@example.com',
        ]);

        $response = $c->show($request, 'localhost', 2);

        $result = json_decode($response->getContent(), true);

        self::assertEquals([
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
        ], $result);
    }
}
