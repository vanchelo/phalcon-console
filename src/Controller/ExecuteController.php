<?php

namespace Vanchelo\Console\Controller;

class ExecuteController extends ControllerBase
{
    protected $restful = true;

    public function indexAction()
    {
        $code = $this->request->getPost('code');

        // Execute and profile the code
        $response = $this->di['console']->execute($code);

        // Response
        return $response;
    }
}
