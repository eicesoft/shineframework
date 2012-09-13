<?php
define('CORE_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

/**
 * 自动载入器
 */
class Autoload
{
	public static $loaderfile = array();

	/**
	 * 自动载入类文件
	 * @static
	 * @param string $className
	 * @throws Exception
	 */
	public static function loader( $className )
	{
		$className = str_replace( "\\", DS, $className );
//		echo $className.'<br />';
//		\Core\Monitor\Debug::Instance()->trace($className);
		$file = CORE_PATH . DS . $className . '.php';
		if (is_readable( $file )) {
			self::$loaderfile[] = $file;
//			echo $file.'<br />';
			include($file);
		}
		else
			throw new Exception("don't find file:{$file}");
	}

	public static function init()
	{
		spl_autoload_register( 'Autoload::loader' );
	}
}

Autoload::init();