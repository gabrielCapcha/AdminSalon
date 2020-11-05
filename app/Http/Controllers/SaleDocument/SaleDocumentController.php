<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Entity\Utils\UtilsLogic;
use Illuminate\Http\Request;
use Auth;

class SaleDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $jsonResponse = new \stdClass();
        $utils = new UtilsLogic();
        $jsonResponse->user = $user;
        $jsonResponse->products = $utils->getProductList();
        $jsonResponse->tittle = 'Nueva Venta';
        return view('Sales.new-sale-document', compact('jsonResponse', $jsonResponse));
    }
    public function createSales(Request $request)
    {
        $user = Auth::user();
        $be = new SalesLogic();
        $Sales = $be->createSales($request->all());
        return $Sales;
    }
    public function updateSales(Request $request)
    {
        $user = Auth::user();
        $be = new SalesLogic();
        $Sales = $be->updateSales($request->all());
        return $Sales;
    }
    public function deleteSales($id)
    {
        $user = Auth::user();
        $be = new SalesLogic();
        $Sales = $be->deleteSales($id);
        return $Sales;
    }
}
