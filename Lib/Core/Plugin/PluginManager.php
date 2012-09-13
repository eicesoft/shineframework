<?php
namespace Core\Plugin;

class PluginManager
{
	/**
	 * @var PluginManager
	 */
	private static $instance = null;

	/**
	 * @static
	 * @return PluginManager
	 */
	public static function Instance()
	{
		if (null === self::$instance) {
			self::$instance = new PluginManager();
		}

		return self::$instance;
	}

	/**
	 * 插件
	 * @var array
	 */
	private $plugins;

	private function __construct()
	{
		$this->plugins = array();
	}

	/**
	 * 注册事件
	 * @param string $pluginName
	 */
	public function registry( $pluginName )
	{
		if (isset($this->events[$pluginName])) {
			$this->events[$pluginName] = new $pluginName();
			$this->events[$pluginName]->registry();
		}
	}
}