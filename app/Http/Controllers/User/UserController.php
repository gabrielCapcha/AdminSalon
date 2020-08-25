<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Entity\User\UserLogic;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new UserLogic();
        $list = $user->getUserList();
        return $list;
    }
}
