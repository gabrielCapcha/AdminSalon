<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use App\Entity\Customer\CustomerLogic;
use Illuminate\Http\Request;
use Auth;
use HttpClient;

class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchNewClient(Request $params)
    {
        $user = Auth::user();
        $params = $params->all();
        if ($params['type_document'] == 'DNI') {
            $url  = env('URL_CLIENT') . 'dni/' . $params['document'] .'?token=abcxyz';
        } else {
            $url  = env('URL_CLIENT') . 'ruc/' . $params['document'] .'?token=abcxyz';
        }
        $request = [
            'url'  => $url,
            'headers' => ['Content-Type: application/json'],
        ];
        $response = HttpClient::get($request);
        $response = $response->json();
        return response()->json($response);
    }
    public function index()
    {
        $user = Auth::user();
        $be = new CustomerLogic();
        $list = $be->getCustomerList();
        $jsonResponse = new \stdClass();
        $jsonResponse->user = $user;
        $jsonResponse->Customers = $list;
        $jsonResponse->tittle = 'Customeros';
        return view('Customer.Customer-list', compact('jsonResponse', $jsonResponse));
    }
    public function getObjectById($id)
    {
        $user = Auth::user();
        $be = new CustomerLogic();
        $Customer = $be->getCustomerById($id);
        return $Customer;
    }
    public function createCustomer(Request $request)
    {
        $user = Auth::user();
        $be = new CustomerLogic();
        $Customer = $be->createCustomer($request->all());
        return $Customer;
    }
    public function updateCustomer($id = null, Request $request)
    {
        $user = Auth::user();
        $be = new CustomerLogic();
        $Customer = $be->updateCustomer($id, $request->all());
        return $Customer;
    }
    public function deleteCustomer($id = null)
    {
        $user = Auth::user();
        $be = new CustomerLogic();
        $Customer = $be->deleteCustomer($id);
        return $Customer;
    }
}
