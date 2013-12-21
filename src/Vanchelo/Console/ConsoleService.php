<?php namespace Vanchelo\Console;

use Phalcon\DI;
use Phalcon\Mvc\View\Simple as View;

class ConsoleService
{

    /**
     * The application instance.
     *
     * @var \Phalcon\DI
     */
    protected $di;

    /**
     * Create a new service provider instance.
     *
     * @param  \Phalcon\DI $app
     * @return void
     */
    public function __construct(DI $di)
    {
        $this->di = $di;

        $this->registerConfig();
        $this->registerRoutes($this->di['router']);
        $this->registerViewService();
        $this->registerConsoleService();
    }

    protected function registerRoutes($router)
    {
        require __DIR__ . '/config/routes.php';
    }

    protected function registerConsoleService()
    {
        $this->di['console'] = function() {
            $console = new Console();

            return $console;
        };
    }

    protected function registerViewService()
    {
        $this->di['console.view'] = function() {
            $view = new View();

            $view->setViewsDir($this->di['console.config']->viewsDir);

            return $view;
        };
    }

    protected function registerConfig()
    {
        $this->di['console.config'] = function () {
            $config = require __DIR__ . '/config/config.php';

            return $config;
        };
    }

}