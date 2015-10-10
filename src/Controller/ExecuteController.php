<?php

namespace Vanchelo\Console\Controller;

class ExecuteController extends ControllerBase
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $code = $this->request->getPost('code');

        // Execute and profile the code
        $response = $this->di['console']->execute($code);

        // Response
        return $response;
    }
}
