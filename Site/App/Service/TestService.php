<?php
namespace App\Service;

use Core\Business\Service;

/**
 * 测试服务
 */
class TestService extends Service
{
	/**
	 * @var \App\Model\UserModel
	 */
	protected $UserModel;

	/**
	 * @return array
	 */
	public function test()
	{
		return $this->UserModel->Get('12344');
	}
}