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

Route::namespace('backend')->group(function(){

	Route::get('/', function () {return view('layouts.backend');})->name('admin');

	//admin_roles	
	Route::resource('admin_roles', 'AdminRoleController');
	Route::post('admin_roles/search', 'AdminRoleController@search')->name('admin_roles.search');
	
	//admins	
	Route::resource('admins', 'AdminController');
	Route::post('admins/search','AdminController@search')->name('admins.search');

	//users
	Route::resource('users', 'UserController');
	Route::post('users/search','UserController@search')->name('users.search');

	Route::get('/categories','CategoryController@index')->name('categories.index');

});
