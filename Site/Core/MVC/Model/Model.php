<?php
namespace Core\MVC\Model;

/**
 * 数据模型
 */
class Model
{
    /**
     * 数据索引用户ID
     * @var int
     */
    protected $uid;

    /**
     * @var 是否为单行数据
     */
    protected $is_single;

    protected $config;

    public function __construct()
    {
        $this->config = \Core\Config::instance();
    }

    /**
     * @param int $uid
     */
    public function setMainId($uid)
    {
        $this->uid = $uid;
    }
}
