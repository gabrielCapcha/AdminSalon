<?php

namespace App\Http\Controllers\Sales\Api;

use App\Http\Controllers\Controller;
use App\Entity\Sales\SalesLogic;
use Illuminate\Http\Request;
use Auth;

class SaleDocumentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $be = new SalesLogic();
        $list = $be->getSalesList();
        $jsonResponse = new \stdClass();
        $jsonResponse->user = $user;
        $jsonResponse->Saless = $list;
        $jsonResponse->tittle = 'Salesos';
        return view('Sales.Sales-list', compact('jsonResponse', $jsonResponse));
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
    public function searchClient(Request $request)
    {
        $user = Auth::user();
        $be = new SalesLogic();
        $Sales = $be->updateSales($request->all());
        return $Sales;
    }
}
