<?php
namespace Core\MVC\Model\DataSource;

use Core\Error\CoreError;

class PDODataSource {
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

	public function query($sql) {
		$pdostmt = $this->handle->prepare($sql);

		$pdostmt->fetch($this->fetchStyle);
	}
}