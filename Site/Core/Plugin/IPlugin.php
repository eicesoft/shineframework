<?php
namespace Core\Plugin;

interface IPlugin
{
	/**
	 * 插件注册
	 * @abstract
	 * @return mixed
	 */
	public function registry();

	/**
	 * 插件执行
	 * @abstract
	 * @return mixed
	 */
	public function startRouter();
	
	public function endRouter();
	
	public function startDispatcher();
	
	public function endDispatcher();
	
	public function execute();
	
	public function startView($viewData);
	
	public function endView($view);
}