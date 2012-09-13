<?php
namespace Core\MVC\View;

use Core\MVC\View\View;

/**
 * 基本页面视图
 */
class SimpleView extends View {
	private $viewDatas;

	private $viewFile;

	public function __construct($view) {
		$this->viewFile = APP_PATH . DS . 'View' . $view . '.tpl.php';
	}

	public function assign($key, $var) {
		$this->viewDatas[$key] = $var;
	}

	public function assigns($vars) {
		$this->viewDatas = $vars;
	}

	public function display()
	{
		extract($this->viewDatas);

		if(is_readable($this->viewFile)) {
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
				return json_encode($this->viewDatas);
			}
		}
	}
}