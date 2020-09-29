<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Entity\Product\ProductLogic;
use Auth;

class ProductController extends Controller
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
        $jsonResponse = new \stdClass();
        $jsonResponse->user = $user;
        $jsonResponse->products = $list;
        $jsonResponse->tittle = 'Productos';
        return view('Product.product-list', compact('jsonResponse', $jsonResponse));
    }
}
