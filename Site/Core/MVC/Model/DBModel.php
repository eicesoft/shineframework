<?php
namespace Core\MVC\Model;

use Core\MVC\Model\DataSource\PDODS;
use Core\Error\CoreDataError;

class DBModel extends Model
{
	/**
	 * Redis连接池
	 * @var \Core\MVC\Model\DataSource\PDODS
	 */
	private static $handles;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param int $index
	 * @return PDODS
	 */
	private function &_init_ds($index)
	{
		if (!isset(DBModel::$handles[$index]))
		{
			$configs = $this->config->get('database_index_map', 'dns');
			$key = $configs[$index];

			$rconfigs = $this->config->get('database_source', 'dns');
			$rconfig = $rconfigs[$key];

			DBModel::$handles[$index] = new PDODS($rconfig);

			return  DBModel::$handles[$index];
		}
		else
		{
			return  DBModel::$handles[$index];
		}
	}

	public function find()
	{
		$index = GroupIndex::Instance()->get($this->uid, GroupIndex::TYPE_DATABASE);
		$handle = $this->_init_ds($index);

//		var_dump($handle);
	}
}