<?php
namespace Core\MVC\Model;

use Core\MVC\Model\DataSource\RedisDS;
use Core\Error\CoreDataError;

/**
 * Redis 数据模型
 */
class RedisModel extends Model
{
    protected $table;

    /**
     * Redis连接池
     * @var \Core\MVC\Model\DataSource\RedisDS
     */
    private static $handles;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 初始化数据源
     */
    private function &initData($index)
    {
        if (!isset(RedisModel::$handles[$index])) {
            $configs = $this->config->get('redis_index_map', 'dns');
            $key = $configs[$index];

            $rconfigs = $this->config->get('redis_source', 'dns');
            $rconfig = $rconfigs[$key];

            RedisModel::$handles[$index] = new RedisDS($rconfig);

            return RedisModel::$handles[$index];
        } else {
            return RedisModel::$handles[$index];
        }
    }

    /**
     * 获得用户key名称
     *
     * @return string
     */
    private function table()
    {
        return sprintf($this->table, $this->uid);
    }

    /**
     * 查询数据
     *
     * @param mixed $pk
     * @return mixed
     */
    public function find($pk = null)
    {
        $index = GroupIndex::instance()->get($this->uid, GroupIndex::TYPE_REDIS);
        $handle = $this->initData($index);

        if ($this->is_single) {
            $ret = $handle->hgetall($this->table());
        } else {
            if (null === $pk) {
                $ret = $handle->hgetall($this->table());
                foreach ($ret as &$val) {
                    $val = json_decode($val, true);
                }

                unset($val);
            } else { //查询单行数据
                $ret = json_decode($handle->hget($this->table(), $pk), true);
            }
        }

        return $ret;
    }

    /**
     * 更新数据
     *
     * @param array $datas
     * @param mixed $pk
     * @throws \Core\Error\CoreDataError
     * @return bool
     */
    public function update($datas, $pk = null)
    {
        $index = GroupIndex::instance()->get($this->uid, GroupIndex::TYPE_REDIS);
        $handle = $this->initData($index);

        if ($this->is_single) {
            if ($handle->exists($this->table())) {
                return (bool) $handle->hmset($this->table(), $datas);
            } else {
                throw new CoreDataError('error.data.pknotexist', array($this->table()));
            }
        } else {
            if ($handle->hexists($this->table(), $pk)) {
                return (bool) $handle->hset($this->table(), $pk, json_encode($datas));
            } else {
                throw new CoreDataError('error.data.pknotexist', array($this->table() . '#' . $pk));
            }
        }
    }

    /**
     * 插入数据
     * @param array $datas
     * @param mixed $pk
     * @throws \Core\Error\CoreDataError
     * @return bool
     */
    public function insert($datas, $pk = null)
    {
        $index = GroupIndex::instance()->get($this->uid, GroupIndex::TYPE_REDIS);
        $handle = $this->initData($index);

        if ($this->is_single) {
            if (!$handle->exists($this->table())) {
                return (bool) $handle->hmset($this->table(), $datas);
            } else {
                //return false;
                throw new CoreDataError('error.data.pkexist', array($this->table()));
            }
        } else {
            if (!$handle->hexists($this->table(), $pk)) {
                return (bool) $handle->hset($this->table(), $pk, json_encode($datas));
            } else {
                throw new CoreDataError('error.data.pkexist', array($this->table() . '#' . $pk));
            }
        }
    }

    /**
     * 删除数据
     * @param mixed $pk
     * @return bool
     */
    public function delete($pk = null)
    {
        $index = GroupIndex::instance()->get($this->uid, GroupIndex::TYPE_REDIS);
        $handle = $this->initData($index);

        if ($this->is_single) {
            return (bool) $handle->delete($this->table());
        } else {
            if (null === $pk) {
                return (bool) $handle->del($this->table());
            } else {
                return (bool) $handle->hdel($this->table(), $pk);
            }
        }
    }
}
