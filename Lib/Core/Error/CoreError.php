<?php
namespace Core\Error;

use Core\Lang\Language;

/**
 * 核心异常
 */
class CoreError extends \Exception
{
	public function __construct( $lankey, $params = array() )
	{
		$message = Language::Instance()->get( $lankey, 'core' );

		$this->message = sprintf( $message, $params );
	}
}