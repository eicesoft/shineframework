<?php
namespace Core;

use Core\Error\CoreError;

class Config
{
	private static $instance = null;

	public static function Instance()
	{
		if (null === self::$instance)
		{
			self::$instance = new Config();
		}

		return self::$instance;
	}

	private $datas;

	/**
	 *
	 */
	private function __construct()
	{
		$this->datas = array();
	}

	/**
	 * 载入配置模块
	 * @param string $moudle
	 */
	private function _load($moudle)
	{
		if (!isset($this->datas[$moudle]))
		{
			$file = APP_PATH . DS . 'Config' . DS  . $moudle . '.php';

			if (is_readable($file))
			{
				$this->datas[$moudle] = include($file);
			}
			else
			{
				throw new CoreError('error.configexist', $file);
			}
		}
		else
		{
			//TODO
		}
	}

	public function get($key, $moudle, $default = null)
	{
		$this->_load($moudle);

		return isset($this->datas[$moudle][$key]) ? $this->datas[$moudle][$key] : $default;
	}
}