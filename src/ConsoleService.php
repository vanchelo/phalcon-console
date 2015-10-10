<?php

namespace Vanchelo\Console;

defined('PHALCONSTART') or define('PHALCONSTART', microtime(true));

use Phalcon\DI;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Simple as View;

class ConsoleService
{
    /**
     * The application instance.
     *
     * @var DiInterface
     */
    protected $di;

    /**
     * Create a new service provider instance.
     *
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di = $di;

        $this->registerConfig();
        $this->registerRoutes();
        $this->registerViewService();
        $this->registerConsoleService();
        $this->registerConsoleAccessService();
    }

    /**
     * Register console routes
     */
    protected function registerRoutes()
    {
        $router = $this->di['router'];

        require __DIR__ . '/config/routes.php';
    }

    protected function registerConsoleService()
    {
        $this->di['console'] = function () {
            return new Console();
        };
    }

    protected function registerViewService()
    {
        $this->di['console.view'] = function () {
            $view = new View();

            if ($this->di->has('view')) {
                $this->di['view']->disable();
            }

            $view->setViewsDir($this->di['console.config']->viewsDir);

            return $view;
        };
    }

    protected function registerConfig()
    {
        $config = require __DIR__ . '/config/config.php';

        if ($this->di->has('console.config')) {
            $config->merge($this->di->get('console.config'));
        }

        $this->di['console.config'] = $config;
    }

    protected function registerConsoleAccessService()
    {
        $this->di['console.access'] = $this->di['console.config']->check_access_class;
    }
}
