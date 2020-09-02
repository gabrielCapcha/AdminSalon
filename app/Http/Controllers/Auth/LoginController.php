<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{

    public function showLoginForm() {
        return view('login');
    }

    public function login() {
       $credentials = $this->validate(request(), [
           'email' => 'email|required|string',
           'password' => 'required|string'
       ]);
        $user = Auth::attempt($credentials);
       if (!is_null($user)) {
            return redirect()->route('dashboard')  ;
       } else {
           return view('errors.404');
       }
   }

   public function logout() {
       Auth::logout();

       return redirect('/');
   }
}
