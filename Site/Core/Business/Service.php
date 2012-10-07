<?php
namespace Core\Business;

use Core\Config;
use Core\Monitor\Debug;
use Core\Proxy\ModelProxy;

/**
 * 业务服务基类
 */
class Service {
	/**
	 * @var \Core\Config
	 */
	protected $config;

	/**
	 * @var \Core\Monitor\Debug
	 */
	protected $monitor;

	/**
	 *
	 */
	public function _initModelProxy()
	{
		$ref = new \ReflectionObject($this);
		$properties = $ref->getProperties();
		foreach($properties as $propertie)
		{
			$pname = $propertie->getName();

			if(substr($pname, strlen($pname) - 5) == 'Model')
			{
				$propertie->setAccessible(true);
				$propertie->setValue($this, new ModelProxy($pname));
			}
		}
	}

	public function __construct()
	{
		$this->config = Config::Instance();
		$this->monitor = Debug::Instance();

		$this->_initModelProxy();
	}
}