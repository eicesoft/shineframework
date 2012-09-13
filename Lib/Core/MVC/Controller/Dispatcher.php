<?php
namespace Core\MVC\Controller;

abstract class Dispatcher
{
	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @param Router $router
	 */
	public function setRouter($router) {
		$this->router = $router;
	}

	private function _loadAction($controller, $action) {
		$file = APP_PATH . DS . 'Controller';
		echo $file;
	}

	protected function _call($controller, $action) {

	}

	public abstract function init();

	public abstract function execute();
}