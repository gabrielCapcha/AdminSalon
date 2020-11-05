<?php

namespace App\Http\Controllers\SaleDocument\Api;

use App\Http\Controllers\Controller;
use App\Entity\SaleDocument\SaleDocumentLogic;
use Illuminate\Http\Request;
use Auth;

class SaleDocumentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $user = Auth::user();
        $be = new SaleDocumentLogic();
        $list = $be->getSaleDocumentList();
        return $list;
    }
    public function getById(Request $request)
    {
        $user = Auth::user();
        $be = new SaleDocumentLogic();
        $Sales = $be->getSaleDocumentById($request->all());
        return $Sales;
    }
    public function createObject(Request $request)
    {
        $user = Auth::user();
        $be = new SaleDocumentLogic();
        $Sales = $be->createSaleDocument($request->all());
        return $Sales;
    }
    public function updateObject(Request $request)
    {
        $user = Auth::user();
        $be = new SaleDocumentLogic();
        $Sales = $be->updateSaleDocument($request->all());
        return $Sales;
    }
    public function deleteObject($id)
    {
        $user = Auth::user();
        $be = new SaleDocumentLogic();
        $Sales = $be->deleteSaleDocument($id);
        return $Sales;
    }
    public function searchClient(Request $request)
    {
        $user = Auth::user();
        $be = new SaleDocumentLogic();
        $Sales = $be->updateSaleDocument($request->all());
        return $Sales;
    }
}
