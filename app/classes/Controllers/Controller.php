<?php

namespace Dream\USOS\Controllers;

use Silex\Application;

class Controller
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
