<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::get('/login', 'Auth\LoginController@showAdminLoginForm')->name('admin.login');
Route::post('/login', 'Auth\LoginController@adminLogin')->name('admin.login.post');
Route::get('/logout', 'Auth\LoginController@adminLogout')->name('admin.logout');

Route::middleware('auth:admin')->namespace('backend')->group(function(){

	Route::get('/', function () {return view('layouts.backend');})->name('admin');
	Route::resource('admins', 'AdminController');
	Route::resource('users', 'UserController');

});
