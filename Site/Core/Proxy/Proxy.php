<?php
namespace Core\Proxy;

abstract class Proxy
{
    /**
     * 被代理的Service名称
     * @var string
     */
    protected $proxyName;

    /**
     * @var mixed
     */
    private $proxyObject = null;

    /**
     *
     * @param string $proxyName
     */
    public function __construct($proxyName)
    {
        $this->proxyName = $proxyName;
    }

    abstract protected function getClassName();

    /**
     * 初始化代理对象
     */
    private function init()
    {
        if (null !== $this->proxyObject) {
            return;
        }

        $className = $this->getClassName();

        $this->proxyObject = new $className();
    }

    /**
     *
     * @param string $name
     * @param array $args
     */
    public function __call($name, $args)
    {
        if (null === $this->proxyObject) {
            $this->init();
        }

        return call_user_func_array(array($this->proxyObject, $name), $args);
    }
}
