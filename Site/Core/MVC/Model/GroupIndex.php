<?php
namespace Core\MVC\Model;

use Core\MVC\Model\DataSource\RedisDS;

/**
 * 用户服务器分组索引
 */
class GroupIndex
{
	const TYPE_DATABASE = 0;
	const TYPE_MEMCACHE = 1;
	const TYPE_REDIS = 2;

	const KEY = 'ui%d:%s';

	/**
	 * @var GroupIndex
	 */
	private static $instance = null;

	/**
	 * @return GroupIndex
	 */
	public static function Instance()
	{
		if( null === self::$instance)
		{
			self::$instance = new GroupIndex();
		}

		return self::$instance;
	}

	/**
	 * @var \Core\Config
	 */
	private $config;

	/**
	 * @var \Core\MVC\Model\DataSource\RedisDS
	 */
	private $handle = null;

	private static $indexs = array(
		GroupIndex::TYPE_DATABASE => array(),
		GroupIndex::TYPE_MEMCACHE => array(),
		GroupIndex::TYPE_REDIS => array(),
	);

	private function __construct()
	{
		$this->config = \Core\Config::Instance();
	}

	/**
	 *
	 */
	private function _lazyinit()
	{
		if (null === $this->handle)
		{
			$this->handle = new RedisDS($this->config->get('index_redis', 'dns'));
		}
	}

	/**
	 * @param int $uid
	 * @return array
	 */
	private function _get_key_info($uid)
	{
		$len = strlen($uid);
		$prefix = substr($uid, 0, $len - 3);
		$key = substr($uid, $len - 3);

		return array($prefix, $key);
	}

	/**
	 * 获得用户所在索引
	 * @param int $uid
	 * @param int $type
	 * @return int
	 */
	public function get($uid, $type = GroupIndex::TYPE_DATABASE)
	{
		if (!isset(GroupIndex::$indexs[$type][$uid]))
		{
			$this->_lazyinit();
			list($key, $index) = $this->_get_key_info($uid);
			$key = sprintf(self::KEY, $type, $key);

			if ($this->handle->hexists($key, $index))	//存在索引
			{
				$value = (int)$this->handle->hget($key, $index);
				GroupIndex::$indexs[$type][$uid] = $value;

				return $value;
			}
			else
			{
				switch ($type)
				{
					case GroupIndex::TYPE_DATABASE:
						$config = $this->config->get('database_index_map', 'dns');
						break;
					case GroupIndex::TYPE_MEMCACHE:
						$config = $this->config->get('memcache_index_map', 'dns');
						break;
					case GroupIndex::TYPE_REDIS:
						$config = $this->config->get('redis_index_map', 'dns');
						break;
					default:
						$config = $this->config->get('database_index_map', 'dns');
						break;
				}

				$value = array_rand($config);
				$this->handle->hset($key, $index, $value);
				GroupIndex::$indexs[$type][$uid] = $value;
				return (int)$value;
			}
		}
		else
		{
			return GroupIndex::$indexs[$type][$uid];
		}
	}
}