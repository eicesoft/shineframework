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
	 * 插件列表
	 * @var array
	 */
	private $plugins;

	private function __construct()
	{
		$this->plugins = array();
	}

	/**
	 * 注册插件
	 * @param string $pluginName
	 */
	public function registry( $pluginName )
	{
		if (isset($this->plugins[$pluginName])) {
			$this->plugins[$pluginName] = new $pluginName();
			$this->plugins[$pluginName]->registry();
		}
	}
	
	public function startRouter() {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->startRouter();
		}
	}
	
	public function endRouter() {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->endRouter();
		}
	}
	
	public function startDispatcher() {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->startDispatcher();
		}
	}
	
	public function endDispatcher() {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->startDispatcher();
		}
	}
	
	public function execute() {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->execute();
		}
	}
	
	public function startView($viewData) {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->startView($viewData);
		}
	}
	
	public function endView($view) {
		foreach($this->plugins as $pluginName => $plugin) {
			$plugin->endView($view);
		}
	}
}