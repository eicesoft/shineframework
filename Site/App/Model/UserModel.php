<?php
namespace App\Model;

use Core\MVC\Model\DBModel;

class UserModel extends DBModel
{
    protected $is_single = true;
    protected $table = 'u:%s';

    public function get($uid)
    {
        $this->setMainId($uid);
        /*
        var_dump($this->insert(array(
            'uId' => $uid,
            'uName' => 'test',
            'uAge' => 20
        )));
        */
        return $this->find();
    }
}
