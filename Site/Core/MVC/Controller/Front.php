<?php
namespace Core\MVC\Controller;

use Core\Application;
use Core\Error\CoreError;
use Core\MVC\Controller\Router;
use Core\MVC\Controller\Dispatcher;

/**
 * 前端控制器
 */
class Front
{
	/**
	 * @var Front
	 */
	private static $instance = null;

	/**
	 * @static
	 * @return Front
	 */
	public static function Instance()
	{
		if (null === self::$instance) {
			self::$instance = new Front();
		}

		return self::$instance;
	}

	/**
	 * @var Dispatcher
	 */
	private $dispatcher;

	/**
	 * @var Router
	 */
	private $router;

	private $mode;

	private function __construct()
	{

	}

	public function init()
	{
		switch ($this->mode) {
			case Application::WEB_MODE:
				$this->dispatcher = new \Core\MVC\Controller\Dispatcher\WebDispatcher();
				$this->router = new \Core\MVC\Controller\Router\WebRouter();
				break;
		}
	}

	public function initRouter()
	{
		$this->router->init();
	}

	public function initDispatcher() {
		$this->dispatcher->setRouter($this->router);
		$this->dispatcher->init();
	}

	public function execute() {
		return $this->dispatcher->execute();
	}

	public function setMode( $mode )
	{
		$this->mode = $mode;
	}
}