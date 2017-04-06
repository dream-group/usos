<?php

namespace Dream\USOS\Debug;

class DumpRequest
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function dumpRequest(): void
    {
        $file = $this->path . '/' . uniqid('request_') . '.txt';

        ob_start();

        var_dump($_GET);
        var_dump($_POST);
        var_dump($_SERVER);

        file_put_contents($file, ob_get_clean());
    }
}
