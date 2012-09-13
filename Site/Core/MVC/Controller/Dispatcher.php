<?php
namespace Core\MVC\Controller;

use Core\Error\CoreError;

/**
 * 派发器
 */
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
	 * @param $controller
	 * @param $action
	 * @return Action
	 */
	private function _createAction($controller, $action) {
		$className = 'App\\Controller\\' . $controller . '\\' . $action . 'Action';
		return new $className();
	}

	/**
	 * 调用Action
	 * @param string $controller
	 * @param string $action
	 * @param string $params
	 * @return mixed
	 */
	protected function _call($controller, $action, $params) {
		$this->_loadAction($controller, $action);
		$action = $this->_createAction($controller, $action);

		return call_user_func_array(array(&$action, 'execute'), array($params));
	}

	/**
	 * 派发器初始化
	 * @return mixed
	 */
	public abstract function init();

	/**
	 * 派发器执行
	 * @return mixed
	 */
	public abstract function execute();
}