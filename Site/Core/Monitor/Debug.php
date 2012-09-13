<?php
namespace Core\Monitor;

use Core\Helper\FirePHP;

/**
 * 调试类
 */
class Debug {
	/**
	 * @var \Core\Helper\FirePHP
	 */
	private $firebug;

	/**
	 * @var Debug
	 */
	private static $instance = null;

	/**
	 * @static
	 * @return Debug
	 */
	public static function Instance() {
		if( null === self::$instance ) {
			self::$instance = new Debug();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->firebug = new FirePHP();
		$isdebug = \Core\Application::Instance()->GetConfig('debug');
		$this->firebug->setEnabled($isdebug);
	}

	public function trace($vars, $label = 'TRACE', $method = FirePHP::INFO) {
		call_user_func_array(array($this->firebug, $method), array($vars, $label));
	}
}