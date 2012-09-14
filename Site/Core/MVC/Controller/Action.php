<?php
namespace Core\MVC\Controller;

/**
 *
 */
abstract class Action {
	private $monitor;

	/**
	 * Action执行
	 * @param mixed $param
	 * @return mixed
	 */
	public abstract function execute($param);
}