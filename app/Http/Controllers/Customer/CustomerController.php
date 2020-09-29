<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use App\Entity\Customer\CustomerLogic;

class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $be = new CustomerLogic();
        $list = $be->getCustomerList();
        
        return view('Customer.customer-list', compact());
    }
}
