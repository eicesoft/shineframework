<?php
namespace Core\Error;

use Core\Lang\Language;

/**
 * 核心异常
 */
class CoreError extends \Exception
{
	public function __construct( $lankey, $params = array(), $code = 0 )
	{
		$message = Language::G($lankey, $params);

		parent::__construct($message, $code);
	}
}