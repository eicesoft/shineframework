<?php
namespace Core\MVC\View;

use Core\MVC\View\View;

/**
 * 基本页面视图
 */
class SimpleView implements View {
	private $viewDatas;

	private $viewFile = '';

	public function __construct() {
	}

	public function setView($view) {
		$this->viewFile = APP_PATH . DS . 'View' . DS . $view . '.tpl.php';
	}

	public function assign($key, $var) {
		$this->viewDatas[$key] = $var;
	}

	public function assigns($vars) {
		$this->viewDatas = $vars;
	}

	public function display()
	{
		if(is_readable($this->viewFile)) {

			extract($this->viewDatas);
			ob_start();
			include $this->viewFile;
			$contents = ob_get_clean();

			return $contents;
		} else {
			if(is_scalar($this->viewDatas))
			{
				return $this->viewDatas;
			}
			else
			{
				header('Content-Type:application/json; charset=UTF-8');
				return json_encode($this->viewDatas);
			}
		}
	}
}