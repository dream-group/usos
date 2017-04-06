<?php

namespace Dream\USOS;

use Dream\USOS\Controllers\ApplicantsController;
use Dream\USOS\Controllers\UnknownRequestsController;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\Provider\ServiceControllerServiceProvider;
use Sorien\Provider\PimpleDumpProvider;

class App extends Application
{
    public function __construct()
    {
        parent::__construct();

        if (getenv('APP_ENV') === 'development') {
            $this['debug'] = true;
        }

        $this->registerPaths();
        $this->registerProviders();
        $this->registerServices();
        $this->registerControllers();
        $this->registerRoutes();
    }

    private function registerPaths()
    {
        $this['path.base'] = dirname(dirname(__DIR__));
        $this['path.data'] = $this['path.base'] . '/data';
    }

    private function registerProviders()
    {
        $this->register(new ServiceControllerServiceProvider());

        if ($this['debug']) {
            // dump container for IDE completion
            $this->register(new PimpleDumpProvider());
        }
    }

    private function registerServices()
    {

    }

    private function registerControllers()
    {
        $controllers = [
            'controller.api.applicants'         => ApplicantsController::class,
            'controller.unknown_requests'   => UnknownRequestsController::class,
        ];

        foreach ($controllers as $name => $class) {
            $this[$name] = function () use ($class) {
                return new $class($this);
            };
        }
    }

    private function registerRoutes()
    {
        $this->get('/', function () {
            return 'Workz!';
        });

        $this->mount('/api', function (ControllerCollection $api) {
            $api->mount('/applicants', function (ControllerCollection $applicants) {
                $applicants->get('/', 'controller.api.applicants:get');
            });
        });

        if ($this['debug']) {
            $this->get('/info', function () {
                ob_start();
                phpinfo();
                return ob_get_clean();
            });
        }

        // catch all for debug
        $this->match('/{params}', 'controller.unknown_requests')->assert('params', '.*');
    }
}
