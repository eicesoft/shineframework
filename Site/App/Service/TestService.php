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
     * @var \App\Model\UserItemModel
     */
    protected $UserItemModel;

    /**
     * @return array
     */
    public function test()
    {
        return $this->UserModel->get(1234567892);
    }

    public function test2()
    {
        return $this->UserItemModel->get(123456788);
    }
}
