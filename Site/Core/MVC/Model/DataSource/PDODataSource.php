<?php
namespace Core\MVC\Model\DataSource;

use Core\Error\CoreError;

class PDODataSource {
	const FETCH_TYPE_ALL = 0;
	const FETCH_TYPE_LINE = 1;
	
	private $fetchStyle = \PDO::FETCH_ASSOC;

	/**
	 * @var \PDO
	 */
	private $handle;

	public function __construct($config) {
		$dns = '';
		try {
			$this->handle = new \PDO($dns, $config['user'], $config['password']);
		} catch (\PDOException $ex) {
			throw new CoreError('error.pdo.connect');
		}
	}

	/**
	 * sql query data
	 * @param string $sql
	 * @param int $fetchType
	 * @return mixed
	 */
	public function query($sql, $fetchType = PDODataSource::FETCH_TYPE_ALL) {
		$pdostmt = $this->handle->prepare($sql);
		
		switch ($fetchType) {
			case PDODataSource::FETCH_TYPE_ALL:
				$queryData = $pdostmt->fetchAll($this->fetchStyle);
				break;
			case PDODataSource::FETCH_TYPE_LINE:
				$queryData = $pdostmt->fetch($this->fetchStyle);
				break;
			default:
				$queryData = $pdostmt->fetch($this->fetchStyle);
				break;
		}
		
		return $queryData;
	}
	
	/**
	 * sql execute
	 * @param string $sql
	 * @return int
	 */
	public function execute($sql) {
		$ret = $this->handle->exec($sql);
		
		return $ret;
	}
}