<?php

namespace Vanchelo\Console\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;

abstract class ControllerBase extends Controller
{
    /**
     * Check access rights
     *
     * @param Dispatcher $dispatcher
     *
     * @throws \Phalcon\Mvc\Dispatcher\Exception
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        if (!$this->di['console.access']->check()) {
            throw new DispatcherException('Not Found', 404);
        }
    }

    /**
     * After route executed event
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        $data = $dispatcher->getReturnedValue();

        if (is_array($data)) {
            $this->response->setJsonContent($data, JSON_UNESCAPED_UNICODE);
        } elseif (is_scalar($data)) {
            $this->response->setContent($data);
        }

        $this->response->send();
        exit();
    }
}