<?php
namespace Core\MVC\Controller\Dispatcher;

use Core\MVC\Controller\Dispatcher;

/**
 * Web 页面派发器
 */
class WebDispatcher extends Dispatcher
{
	/**
	 * 初始化派发器
	 * @return mixed|void
	 */
	public function init()
	{

	}

	public function execute()
	{
		return $this->_call($this->router->getController(),
			$this->router->getAction(), $this->router->getParams());
	}
}