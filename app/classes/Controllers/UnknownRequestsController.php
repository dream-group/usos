<?php

namespace Dream\USOS\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnknownRequestsController extends Controller
{
    public function __invoke()
    {
        $file = $this->app['path.data'] . '/' . uniqid('request_') . '.txt';

        ob_start();

        var_dump($_GET);
        var_dump($_POST);
        var_dump($_SERVER);

        file_put_contents($file, ob_get_clean());

        throw new NotFoundHttpException('Unknown route');
    }
}
