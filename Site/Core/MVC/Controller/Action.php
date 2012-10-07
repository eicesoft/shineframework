<?php
namespace Core\MVC\Controller;

use Core\Config;

/**
 * Action执行器基类
 */
abstract class Action {
	/**
	 * @var \Core\Monitor\Debug
	 */
	private $monitor;

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		$this->monitor = \Core\Monitor\Debug::Instance();
	}

	/**
	 * Action执行
	 * @param mixed $param
	 * @return mixed
	 */
	public abstract function execute($param);
}