<?php
namespace Core\MVC\Controller;

use Core\Error\CoreError;

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

	/**
	 * 载入Action文件
	 * @param string $controller
	 * @param string $action
	 * @throws \Core\Error\CoreError
	 */
	private function _loadAction($controller, $action) {
		$file = APP_PATH . DS . 'Controller' . DS  . $controller . DS . $action . 'Action.php';
		if(is_readable($file)) {
			require $file;
		} else {
			throw new CoreError('error.notaction', array($controller, $action));
		}
	}

	/**
	 * @param string $controller
	 * @param string $action
	 * @param string $params
	 * @return mixed
	 */
	protected function _call($controller, $action, $params) {
		$this->_loadAction($controller, $action);
		$className = 'App\\Controller\\' . $controller . '\\' . $action . 'Action';
		$action = new $className();
		return call_user_func_array(array(&$action, 'execute'), $params);
	}

	public abstract function init();

	public abstract function execute();
}