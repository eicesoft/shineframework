<?php
namespace Core\MVC\Model;

use Core\MVC\Model\DataSource\RedisDS;
use Core\Error\CoreDataError;

/**
 * Redis 数据模型
 */
class RedisModel extends Model
{
	protected $key;

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
	private function &_init_ds($index)
	{
		if (!isset(RedisModel::$handles[$index]))
		{
			$configs = $this->config->get('redis_index_map', 'dns');
			$key = $configs[$index];

			$rconfigs = $this->config->get('redis_source', 'dns');
			$rconfig = $rconfigs[$key];

			RedisModel::$handles[$index] = new RedisDS($rconfig);

			return  RedisModel::$handles[$index];
		}
		else
		{
			return RedisModel::$handles[$index];
		}
	}

	/**
	 * 获得用户key名称
	 * @return string
	 */
	private function key()
	{
		return sprintf($this->key, $this->uid);
	}

	/**
	 * @param mixed $pk
	 * @return mixed
	 */
	public function find($pk = null)
	{
		$index = GroupIndex::Instance()->get($this->uid);
		$handle = $this->_init_ds($index);

		if ($this->is_single)
		{
			$ret = $handle->hgetall($this->key());
		}
		else
		{
			if (null === $pk)
			{
				$ret = $handle->hgetall($this->key());
				foreach($ret as &$val)
				{
					$val = json_decode($val, true);
				}

				unset($val);
			}
			else	//查询单行数据
			{
				$ret = json_decode($handle->hget($this->key(), $pk), true);
			}
		}

		return $ret;
	}

	/**
	 * 更新数据
	 * @param array $datas
	 * @param mixed $pk
	 * @throws \Core\Error\CoreDataError
	 * @return bool
	 */
	public function update($datas, $pk = null)
	{
		$index = GroupIndex::Instance()->get($this->uid);
		$handle = $this->_init_ds($index);

		if ($this->is_single)
		{
			if ($handle->exists($this->key()))
			{
				return (bool)$handle->hmset($this->key(), $datas);
			}
			else
			{
//				return false;
				throw new CoreDataError('error.data.pknotexist', array($this->key()));
			}
		}
		else
		{
			if ($handle->hexists($this->key(), $pk))
			{
				return (bool)$handle->hset($this->key(), $pk, json_encode($datas));
			}
			else
			{
//				return false;
				throw new CoreDataError('error.data.pknotexist', array($this->key() . '#' . $pk));
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
		$index = GroupIndex::Instance()->get($this->uid);
		$handle = $this->_init_ds($index);

		if ($this->is_single)
		{
			if(!$handle->exists($this->key()))
			{
				return (bool)$handle->hmset($this->key(), $datas);
			}
			else
			{
				//return false;
				throw new CoreDataError('error.data.pkexist', array($this->key()));
			}
		}
		else
		{
			if (!$handle->hexists($this->key(), $pk))
			{
				return (bool)$handle->hset($this->key(), $pk, json_encode($datas));
			}
			else
			{
//				return false;
				throw new CoreDataError('error.data.pkexist', array($this->key() . '#' . $pk));
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
		$index = GroupIndex::Instance()->get($this->uid);
		$handle = $this->_init_ds($index);

		if ($this->is_single)
		{
			return (bool)$handle->delete($this->key());
		}
		else
		{
			if(null === $pk)
			{
				return (bool)$handle->del($this->key());
			}
			else
			{
				return (bool)$handle->hdel($this->key(), $pk);
			}
		}
	}
}