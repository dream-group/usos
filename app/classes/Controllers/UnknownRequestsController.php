<?php

namespace Dream\USOS\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnknownRequestsController extends Controller
{
    public function __invoke()
    {
        $this->app['debug.dump_request']->dumpRequest();

        throw new NotFoundHttpException('Unknown route');
    }
}
