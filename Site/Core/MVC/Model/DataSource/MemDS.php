<?php
namespace Core\MVC\Model\DataSource;

use Core\Error\CoreError;

/**
 * Memcache数据源
 */
class MemDS
{
    const NULL_VAL = '&n$';
    const FALSE_VAL = '&f$';
    const EMPTY_VAL = '&s$';
    const ARRAY_VAL = '&a$';
    const ZERO_VAL = '&0$';

    /**
     * @var \Memcache
     */
    private $handle;

    public function __construct($config)
    {
        $this->handle = new \Memcache();


        $ispersistent = isset($config['persistent']) ? (bool) $config['persistent'] : true;
        $timeout = isset($config['timeout']) ? (int) $config['timeout'] : 1;

        if ($ispersistent) {
            $this->handle->pconnect($config['host'], $config['port'], $timeout);
        } else {
            $this->handle->pconnect($config['host'], $config['port'], $timeout);
        }
    }

    /**
     * 值替换编码
     * @param $val
     * @return string
     */
    private function encode($val)
    {
        if ($val === null) {
            $val = self::NULL_VAL;
        } elseif ($val === 0) {
            $val = self::ZERO_VAL;
        } elseif ($val === false) {
            $val = self::FALSE_VAL;
        } elseif ($val === '') {
            $val = self::EMPTY_VAL;
        } elseif ($val === array()) {
            $val = self::ARRAY_VAL;
        }

        return $val;
    }

    /**
     * 值替换反编码
     * @param mixed $val
     * @return mixed
     */
    private function decode($val)
    {
        if ($val === self::NULL_VAL) {
            $val = null;
        } elseif ($val === self::ZERO_VAL) {
            $val = 0;
        } elseif ($val === self::FALSE_VAL) {
            $val = false;
        } elseif ($val === self::EMPTY_VAL) {
            $val = '';
        } elseif ($val === self::ARRAY_VAL) {
            $val = array();
        }

        return $val;
    }

    public function set($key, $val, $expire = 3600)
    {
        $ret = $this->handle->set($key, $this->encode($val), is_scalar($val) ? 0 : MEMCACHE_COMPRESSED, $expire);

        return $ret;
    }

    public function incr($key, $val = 1, $expire = 3600)
    {
        $ret = $this->handle->increment($key, $val, 0, $expire);
        return $ret;
    }

    public function decr($key, $val = 1, $expire = 3600)
    {
        $ret = $this->handle->decrement($key, $val, 0, $expire);
        return $ret;
    }

    public function get($key)
    {
        return $this->decode($this->handle->get($key));
    }

    public function delete($key, $expire = 0)
    {
        return $this->handle->delete($key, $expire);
    }
}
