<?php
namespace Core\MVC\Controller;

use Core\Error\CoreError;
use Core\Proxy\ServiceProxy;

/**
 * 派发器
 */
abstract class Dispatcher
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Router $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * 载入Action文件
     * @param string $controller
     * @param string $action
     * @throws \Core\Error\CoreError
     */
    private function _loadAction($controller, $action)
    {
        $file = APP_PATH . DS . 'Controller' . DS . $controller . DS . $action . 'Action.php';
        if (is_readable($file)) {
            require $file;
        } else {
            throw new CoreError('error.notaction', array($controller, $action));
        }
    }

    /**
     * 创建Action
     * @param string $controller
     * @param string $action
     * @return Action
     */
    private function createAction($controller, $action)
    {
        $className = 'App\\Controller\\' . $controller . '\\' . $action . 'Action';

        return new $className();
    }

    /**
     * 初始化Action Service Proxy
     * @param Action $action
     */
    private function initServiceProxy(Action &$action)
    {
        $ref = new \ReflectionObject($action);
        $properties = $ref->getProperties();
        foreach ($properties as $propertie) {
            $pname = $propertie->getName();

            if (substr($pname, strlen($pname) - 7) == 'Service') {
                $propertie->setAccessible(true);
                $propertie->setValue($action, new ServiceProxy($pname));
            }
        }
    }

    /**
     * 调用Action
     * @param string $controller
     * @param string $action
     * @param string $params
     * @return mixed
     */
    protected function call($controller, $action, $params)
    {
        $this->_loadAction($controller, $action);
        $action = $this->createAction($controller, $action);
        $this->initServiceProxy($action);

        return call_user_func_array(array(&$action, 'execute'), array($params));
    }

    /**
     * 派发器初始化
     * @return mixed
     */
    abstract public function init();

    /**
     * 派发器执行
     * @return mixed
     */
    abstract public function execute();
}
