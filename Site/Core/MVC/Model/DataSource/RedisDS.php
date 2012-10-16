<?php
namespace Core\MVC\Model\DataSource;

class RedisDS
{
    private $config;

    /**
     * @var Redis
     */
    private $handle = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function init()
    {
        if (null === $this->handle) {
            $this->handle = new \Redis();
            $this->handle->pconnect($this->config['host'], $this->config['port']);
        }
    }

    public function __call($name, $arguments)
    {
        $this->init();
        \Core\Monitor\Debug::instance()->trace(array($name, $arguments), 'Redsis:' . $name);
        return call_user_func_array(array(&$this->handle, $name), $arguments);
    }
}
