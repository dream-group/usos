<?php

namespace Dream\USOS\Controllers;

use Dream\USOS\App;

class Controller
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }
}
