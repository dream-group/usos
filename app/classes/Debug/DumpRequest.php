<?php

declare(strict_types=1);

namespace Dream\USOS\Debug;

use Psr\Http\Message\ServerRequestInterface;

final class DumpRequest
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function dumpRequest(ServerRequestInterface $request): void
    {
        $file = $this->path . '/' . uniqid('request_') . '.txt';

        ob_start();

        var_dump($request->getBody());
        var_dump($request->getQueryParams());
        var_dump($request->getHeaders());

        file_put_contents($file, ob_get_clean());
    }
}
