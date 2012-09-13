<?php
namespace Core\Event;

/**
 * 事件接口
 */
interface IEvent
{
	/**
	 * 事件执行
	 * @abstract
	 * @param array $params
	 * @return mixed
	 */
	public function execute( $params );
}