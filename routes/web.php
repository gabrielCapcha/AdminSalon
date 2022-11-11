<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/soap', 'Auth\LoginController@soap')->middleware('guest');

Route::get('/', 'Auth\LoginController@showLoginForm')->middleware('guest');

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
Route::get('/user', 'User\UserController@index');
Route::get('/product', 'Product\ProductController@index');
//sales
Route::get('/new-sale', 'Sales\SaleDocumentController@index');


/* Auth::routes(); */

Route::get('/home', 'HomeController@index')->name('home');
