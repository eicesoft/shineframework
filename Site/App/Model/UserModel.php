<?php
namespace App\Model;

use Core\MVC\Model\DBModel;

class UserModel extends DBModel
{
	public function Get($uid)
	{
		return array($uid);
	}
}