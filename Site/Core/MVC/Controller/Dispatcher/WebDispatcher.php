<?php
namespace Core\MVC\Controller\Dispatcher;

use Core\MVC\Controller\Dispatcher;

class WebDispatcher extends Dispatcher
{

	public function init()
	{

	}

	public function execute()
	{
		return $this->_call($this->router->getController(),
			$this->router->getAction(), $this->router->getParams());
	}
}