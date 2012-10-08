<?php
namespace App\Model;

use Core\MVC\Model\RedisModel;

class UserModel extends RedisModel
{
	protected $is_single = true;
	protected $key = 'u:%s';

	public function Get($uid)
	{
		//$index = \Core\MVC\Model\GroupIndex::Instance();
		//return $index->get($uid, \Core\MVC\Model\GroupIndex::TYPE_MEMCACHE);
		$this->setMainId($uid);
//		var_dump($this->insert(array(
//			'uId' => $uid,
//			'uName' => 'test',
//			'uAge' => 20
//		)));
		$this->find();
		return $this->find();
	}
}