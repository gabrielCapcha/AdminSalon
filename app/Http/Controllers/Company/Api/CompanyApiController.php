<?php

namespace App\Http\Controllers\Company\Api;

use App\Http\Controllers\Controller;
use App\Entity\Company\CompanyLogic;

class CompanyApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new CompanyLogic();
        $list = $user->getCompanyList();
        return $list;
       /* return view('Admin.dashboard'); */
    }
}
