<?php
namespace Core;

use Core\Error\CoreError;
use Core\MVC\Controller\Front;
use Core\Monitor\Debug;

/**
 * 核心应用类
 */
class Application
{
	const WEB_MODE = 0;
	const FLASH_MODE = 1;
	const SOCKET_MODE = 2;
	const TEST_MODE = 3;

	/**
	 * @var Application
	 */
	private static $instance = null;

	/**
	 * @static
	 * @return Application
	 */
	public static function Instance()
	{
		if (null === self::$instance) {
			self::$instance = new Application();
		}

		return self::$instance;
	}

	/**
	 * @var array
	 */
	private $appconfigs;

	/**
	 * @var string
	 */
	private $apppath;

	/**
	 * @var Front
	 */
	private $front;

	private $view;

	/**
	 * 路由模式
	 * @var int
	 */
	private $mode;

	private function __construct()
	{
		$this->_loadAppConfig();
		$this->front = Front::Instance();
	}

	private function _loadAppConfig()
	{
		$this->appconfigs = require(__DIR__ . DS . 'appconfig.php');
	}

	public function GetConfig( $key )
	{
		return isset($this->appconfigs[$key]) ? $this->appconfigs[$key] : null;
	}

	public function setAppPath( $apppath )
	{
		$this->apppath = $apppath;
	}

	public function getAppPath()
	{
		return $this->apppath;
	}

	public function run()
	{
		$this->front->setMode( $this->mode );
		$this->front->init();
		$this->front->initRouter();
		$this->front->initDispatcher();

		$execData = $this->front->execute();
		Debug::Instance()->trace($execData, 'Action result');
	}

	/**
	 * @param int $mode
	 */
	public function setMode( $mode )
	{
		$this->mode = $mode;
	}
}