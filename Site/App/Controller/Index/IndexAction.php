<?php
namespace App\Controller\Index;

use Core\MVC\Controller\Action;

/**
 *
 */
class IndexAction extends Action{
	/**
	 * @param $param
	 * @return array
	 */
	public function execute($param) {
		return $param;
	}
}