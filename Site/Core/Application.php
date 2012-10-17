<?php
namespace Core;

use Core\Error\CoreError;
use Core\MVC\Controller\Front;
use Core\Monitor\Debug;
use Core\Plugin\PluginManager;

/**
 * 核心应用类
 */
class Application
{
    const WEB_MODE = 0;
    const FLASH_MODE = 1;
    const SOCKET_MODE = 2;
    const TEST_MODE = 3;

    /**
     * @var Application
     */
    private static $instance = null;

    /**
     * @static
     * @return Application
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new Application();
        }

        return self::$instance;
    }

    /**
     * @var array
     */
    private $appconfigs;

    /**
     * @var string
     */
    private $apppath;

    /**
     * @var Front
     */
    private $front;

    /**
     * 路由模式
     * @var int
     */
    private $mode;

    /**
     *
     * @var Plugin\PluginManager
     */
    private $plugin;

    /**
     * construct function
     */
    private function __construct()
    {
        $this->loadAppConfig();
        $this->front = Front::Instance();
        $this->plugin = PluginManager::Instance();
    }

    private function init()
    {
        $this->plugin->registry('HttpPlugin');
    }

    /**
     * load app config
     */
    private function loadAppConfig()
    {
        $this->appconfigs = require(__DIR__ . DS . 'appconfig.php');
        foreach ($this->appconfigs as $key => $appconfig) {
            $defstring = 'CORE_' . strtoupper($key);

            if (!defined($defstring)) {
                define($defstring, $appconfig);
            }
        }
    }

    /**
     * get app config
     * @param string $key
     * @return mixed
     */
    public function getConfig($key)
    {
        return isset($this->appconfigs[$key]) ? $this->appconfigs[$key] : null;
    }

    /**
     * 设置App path
     * @param string $apppath
     */
    public function setAppPath($apppath)
    {
        $this->apppath = $apppath;
    }

    /**
     * get app path
     * @return string
     */
    public function getAppPath()
    {
        return $this->apppath;
    }

    /**
     * App执行
     */
    public function run()
    {
        $this->front->setMode($this->mode);
        $this->front->init();

        $this->plugin->startRouter();
        $this->front->initRouter();
        $this->plugin->endRouter();

        $this->plugin->startDispatcher();
        $this->front->initDispatcher();
        $this->plugin->endDispatcher();

        $this->plugin->execute();
        $execData = $this->front->execute();

        $this->plugin->startView($execData);
        $view = $this->front->display($execData);
        $this->plugin->endView($view);

        echo $view;
    }

    /**
     * 设置路由模式
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }
}
