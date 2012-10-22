<?php
namespace App\Model;

use Core\MVC\Model\RedisModel;

/**
 * 用户物品表
 * 
 * @author kelzyb <eicesoft@126.com>
 */
class UserItemModel extends RedisModel
{
    protected $is_single = false;
    protected $table = 'ui:%s';

    /**
     * get 用户数据
     * 
     * @param int $uid 用户ID
     * 
     * @return mixed
     */
    public function get($uid)
    {
        $this->setMainId($uid);

        //var_dump($this->insert(array(
        //    'uId'    => $uid,
        //    'iId'    => 106,
        //    'uiSize' => 4
        //), 3));

        //var_dump($this->update(array(
        //    'uId'    => $uid,
        //    'iId'    => 103,
        //    'uiSize' => 99), 2)
        //);

        var_dump($this->delete());

        return $this->find();
    }
}
