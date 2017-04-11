<?php

namespace Dream\USOS;

use Dream\USOS\Api\DreamApplyApiFactory;
use Dream\USOS\Controllers\ApplicantsController;
use Dream\USOS\Controllers\ErrorController;
use Dream\USOS\Debug\DumpRequest;
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
        $this['factory.dreamapply.api'] = function () {
            return new DreamApplyApiFactory();
        };

        $this['debug.dump_request'] = function () {
            return new DumpRequest($this['path.data']);
        };
    }

    private function registerControllers()
    {
        $controllers = [
            'controller.api.applicants'     => ApplicantsController::class,
            'controller.error'              => ErrorController::class,
        ];

        foreach ($controllers as $name => $class) {
            $this[$name] = function () use ($class) {
                return new $class($this);
            };
        }
    }

    private function registerRoutes()
    {
        if ($this['debug']) {
            $this->get('/info', function () {
                ob_start();
                phpinfo();
                return ob_get_clean();
            });
        }

        $this->mount('/{host}', function (ControllerCollection $host) {
            $host->mount('/api', function (ControllerCollection $api) {
                $api->mount('/applicants', function (ControllerCollection $applicants) {
                    $applicants->get('/', 'controller.api.applicants:get');
                });
            });
        });

        $this->error($this['controller.error']);
    }
}
