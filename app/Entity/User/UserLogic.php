<?php
namespace App\Entity\User;

use App\Models\User;

class UserLogic
{
    #private functions
    #public functions
    public function getUserList($params = [])
    {
        $list = User::select(User::TABLE_NAME . '.*')
        ->get();
        return $list;
    }
}