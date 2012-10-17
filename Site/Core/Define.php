<?php
namespace Core;

class Define
{
    private static $vars = array();

    /**
     * 设置定义的常量表
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value, $safe = false)
    {
        if ($safe) {    //安全的
            if (isset(self::$vars[$key])) {
                //TODO throw new error.
                return;
            }
        }

        self::$vars[$key] = $value;
    }

    /**
     * 获得定义的常量
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (isset(self::$vars[$key])) {
            return self::$vars[$key];
        } else {
            return $default;
        }
    }
}
