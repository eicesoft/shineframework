<?php
namespace Core\Monitor;

use Core\Helper\FirePHP;
use Core\Helper\ChromePhp;

/**
 * 调试类
 */
class Debug
{
    /**
     * @var
     */
    private $debuginstance;

    /**
     * @var Debug
     */
    private static $instance = null;

    /**
     * @static
     * @return Debug
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new Debug();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $isdebug = \Core\Application::instance()->getConfig('debug');
        $debugtype = \Core\Application::instance()->getConfig('debugtype');

        switch ($debugtype) {
            case 'firebug':
                $this->debuginstance = new FirePHP();
                break;
            case 'chromephp':
                $this->debuginstance = ChromePhp::getInstance();
                break;
            default:
                $this->debuginstance = new FirePHP();
                break;
        }

        $this->debuginstance->setEnabled($isdebug);
    }

    public function trace($vars, $label = 'TRACE', $method = FirePHP::INFO)
    {
        call_user_func_array(array($this->debuginstance, $method), array($vars, $label));
    }
}
