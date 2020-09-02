<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Entity\Company\Api\CompanyApiController;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new CompanyApiController();
        $list = $user->getCompanyList();
        return $list;
    }
}
