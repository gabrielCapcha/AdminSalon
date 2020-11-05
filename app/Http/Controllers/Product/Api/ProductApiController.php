<?php

namespace App\Http\Controllers\Product\Api;

use App\Http\Controllers\Controller;
use App\Entity\Product\ProductLogic;
use Illuminate\Http\Request;
use Auth;

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
        return  $list;
    }
    public function getObjectById($id)
    {
        $user = Auth::user();
        $be = new ProductLogic();
        $product = $be->getProductById($id);
        return $product;
    }
    public function createProduct(Request $request)
    {
        $user = Auth::user();
        $be = new ProductLogic();
        $product = $be->createProduct($request->all());
        return $product;
    }
    public function updateProduct($id = null, Request $request)
    {
        $user = Auth::user();
        $be = new ProductLogic();
        $product = $be->updateProduct($id, $request->all());
        return $product;
    }
    public function deleteProduct($id = null)
    {
        $user = Auth::user();
        $be = new ProductLogic();
        $product = $be->deleteProduct($id);
        return $product;
    }
}
