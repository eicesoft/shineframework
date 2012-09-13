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

	/**
	 * @var int
	 */
	private $mode;

	/**
	 *
	 */
	private function __construct()
	{

	}

	/**
	 * 基本初始化
	 */
	public function init()
	{
		switch ($this->mode) {
			case Application::WEB_MODE:
				$this->router = new \Core\MVC\Controller\Router\WebRouter();
				$this->dispatcher = new \Core\MVC\Controller\Dispatcher\WebDispatcher();
				break;
			case Application::FLASH_MODE:
				$this->dispatcher = new \Core\MVC\Controller\Dispatcher\FlashDispatcher();
				$this->router = new \Core\MVC\Controller\Router\FlashRouter();
				break;
		}
	}

	/**
	 * 初始化路由器
	 */
	public function initRouter()
	{
		$this->router->init();
	}

	/**
	 * 初始化派发器
	 */
	public function initDispatcher() {
		$this->dispatcher->setRouter($this->router);
		$this->dispatcher->init();
	}

	/**
	 * 派发器执行
	 * @return mixed
	 */
	public function execute() {
		return $this->dispatcher->execute();
	}

	/**
	 * 设置路由模式
	 * @param int $mode
	 */
	public function setMode( $mode )
	{
		$this->mode = $mode;
	}
}