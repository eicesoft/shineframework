<?php
namespace App\Controller\Index;

use Core\MVC\Controller\Action;
use Core\MVC\Model\DataSource\MemDataSource;

/**
 *
 */
class IndexAction extends Action{
	public function __construct() {
	}


	/**
	 * @param $param
	 * @return array
	 */
	public function execute($param) {
		$mem = new MemDataSource(array('host' => '172.17.0.22', 'port' => 11211));
		$mem->set('a1', array());
		var_dump($mem->get('a1'));
		return $param;
	}
}