<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if (!is_null($user)) {
            $jsonResponse = new \stdClass();
            $jsonResponse->user = $user;
            $jsonResponse->tittle = 'Dashboard';
            $view = view('Admin.dashboard', compact('jsonResponse', $jsonResponse));
        } else {
            $view = view('errors.404');
        }
        return $view;
    }
}
