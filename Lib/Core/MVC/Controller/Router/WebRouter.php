<?php
namespace Core\MVC\Controller\Router;

use Core\MVC\Controller\Router;

class WebRouter extends Router
{
	/**
	 * @var string
	 */
	private $controller;

	/**
	 * @var string
	 */
	private $action;

	/**
	 * @var array
	 */
	private $params;

	public function init()
	{
		$qstring = $_SERVER['QUERY_STRING'];

		if($qstring != "") {
			$pathinfo = explode('&', $qstring);

			if(strpos($pathinfo[0], '/')) {
				list($this->controller, $this->action) = explode('/', $pathinfo[0]);
				array_shift($_GET);
			} else {
				$this->controller = 'Index';
				$this->action = 'Index';
			}
		} else {
			$this->controller = 'Index';
			$this->action = 'Index';
		}

		$this->params = $_GET;
	}

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @return string
	 */
	public function getController()
	{
		return $this->controller;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}
}