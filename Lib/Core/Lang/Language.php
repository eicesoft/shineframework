<?php
namespace Core\Lang;

use Core\Application;

/**
 * 语言包
 */
class Language
{
	/**
	 * @var Language
	 */
	private static $instance = null;

	/**
	 * @static
	 * @return Language
	 */
	public static function Instance()
	{
		if (null === self::$instance) {
			self::$instance = new Language();
		}

		return self::$instance;
	}

	/**
	 * @var array
	 */
	private $langdata;

	private $langpath;

	private function __construct()
	{
		$this->langdata = array();
		$app = Application::Instance();
		$this->langpath = $app->getAppPath() . DS . 'Lang' . DS . $app->GetConfig( 'lang' ) . DS;
	}

	/**
	 * @param string $namespace
	 * @throws \Exception
	 */
	private function _load( $namespace )
	{
		if (!isset($this->langdata[$namespace])) {
			$path = $this->langpath . $namespace . '.lang.php';

			if (is_readable( $path )) {
				$this->langdata[$namespace] = require($path);
			} else {
				throw new \Exception('lang file not exists[' . $path . ']');
			}
		}
	}

	/**
	 *
	 * @param string $key
	 * @param string $namespace
	 * @return string
	 */
	public function get( $key, $namespace = 'core' )
	{
		$this->_load( $namespace );

		return isset($this->langdata[$namespace][$key]) ? $this->langdata[$namespace][$key] : null;
	}
}