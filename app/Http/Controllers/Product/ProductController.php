<?php

namespace App\Http\Controllers\Product\Api;

use App\Http\Controllers\Controller;
use App\Entity\Product\ProductLogic;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $be = new ProductLogic();
        $list = $be->getProductList();
        
        return view('Admin.dashboard', compact());
    }
}
