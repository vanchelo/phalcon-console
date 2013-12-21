<?php namespace Vanchelo\Console\Controller;

class IndexController extends ControllerBase
{
	public function indexAction()
	{
		return $this->di['console.view']->render('console');
	}

}