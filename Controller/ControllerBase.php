<?php namespace Vanchelo\Console\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;

abstract class ControllerBase extends Controller
{
    protected $restful = false;

    public function initialize()
    {
        $this->response->setContentType('text/html', 'UTF-8');
        if ($this->restful)
        {
            $this->setJsonResponse();
        }
    }

    // Call this func to set json response enabled
    public function setJsonResponse() {
        $this->view->disable();

        $this->response->setContentType('application/json', 'UTF-8');
    }

    // After route executed event
    public function afterExecuteRoute(Dispatcher $dispatcher) {
        $data = $dispatcher->getReturnedValue();

        if ($this->restful)
        {
            if (is_array($data))
            {
                $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            }

        }

        $this->response->setContent($data);
        $this->response->send();
    }
}