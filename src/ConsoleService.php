<?php namespace Vanchelo\Console;

defined('PHALCONSTART') or define('PHALCONSTART', microtime(true));

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
     * @param \Phalcon\DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;

        $this->registerConfig();
        $this->registerRoutes();
        $this->registerViewService();
        $this->registerConsoleService();
        $this->registerConsoleAccessService();
    }

    protected function registerRoutes()
    {
        $router = $this->di['router'];

        require __DIR__ . '/config/routes.php';
    }

    protected function registerConsoleService()
    {
        $this->di['console'] = 'Vanchelo\Console\Console';
    }

    protected function registerViewService()
    {
        $this->di['console.view'] = function ()
        {
            $view = new View();

            if ($this->di->has('view'))
            {
                $this->di['view']->disable();
            }

            $view->setViewsDir($this->di['console.config']->viewsDir);

            return $view;
        };
    }

    protected function registerConfig()
    {
        $this->di['console.config'] = function ()
        {
            $config = require __DIR__ . '/config/config.php';

            return $config;
        };
    }

    protected function registerConsoleAccessService()
    {
        $this->di['console.access'] = $this->di['console.config']->check_access_class;
    }
}
