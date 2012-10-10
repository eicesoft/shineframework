<?php
namespace App\Model;

use Core\MVC\Model\RedisModel;

class UserItemModel extends RedisModel
{
	protected $is_single = false;
	protected $table = 'ui:%s';

	/**
	 * @param $uid
	 * @return mixed
	 */
	public function Get($uid)
	{
		$this->setMainId($uid);
//
//		var_dump($this->insert(array(
//			'uId' => $uid,
//			'iId' => 106,
//			'uiSize' => 4
//		), 3));

//		var_dump($this->update(array(
//			'uId' => $uid,
//			'iId' => 103,
//			'uiSize' => 99), 2)
//		);

		var_dump($this->delete());

		return $this->find();
	}
}