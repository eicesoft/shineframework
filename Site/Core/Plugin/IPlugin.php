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
	public function execute();
}