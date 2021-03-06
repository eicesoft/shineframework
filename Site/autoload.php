<?php
namespace Loader;

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
     * @throws \Exception
     */
    public static function loader($className)
    {
        $className = str_replace("\\", DS, $className);

        $file = CORE_PATH . DS . $className . '.php';
        if (is_readable($file)) {
            self::$loaderfile[] = $file;

            include($file);
        } else {
            throw new \Exception("don't find file:{$file}");
        }
    }

    public static function init()
    {
        spl_autoload_register('Loader\Autoload::loader');
    }
}

Autoload::init();
