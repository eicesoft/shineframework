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
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new Language();
        }

        return self::$instance;
    }

    /**
     * 返回语言文件
     * @param string $key
     * @param mixed $params
     * @param string $namespace
     * @return string
     */
    public static function getLang($key, $params = null, $namespace = 'core')
    {
        if ($params == null) {
            return Language::instance()->get($key, $namespace);
        } else {
            $tpl = Language::instance()->get($key, $namespace);
            return vsprintf($tpl, $params);
        }
    }

    /**
     * @var array
     */
    private $langdata;

    private $langpath;

    private function __construct()
    {
        $this->langdata = array();
        $app = Application::instance();
        $this->langpath = $app->getAppPath() . DS . 'Lang' . DS . $app->getConfig('lang') . DS;
    }

    /**
     * @param string $namespace
     * @throws \Exception
     */
    private function load($namespace)
    {
        if (!isset($this->langdata[$namespace])) {
            $path = $this->langpath . $namespace . '.lang.php';

            if (is_readable($path)) {
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
    public function get($key, $namespace = 'core')
    {
        $this->load($namespace);

        return isset($this->langdata[$namespace][$key]) ? $this->langdata[$namespace][$key] : null;
    }
}
