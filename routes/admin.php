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

	Route::resource('banners', 'BannerController');
	Route::post('banners/search','BannerController@search')->name('banners.search');

	//categories
	Route::prefix('categories')->group(function(){
		Route::get('/','CategoryController@index')->name('categories.index');
		Route::get('/tree','CategoryController@tree')->name('categories.tree');
		Route::get('/{id}/show','CategoryController@show')->name('categories.show');
		Route::get('/create','CategoryController@create')->name('categories.create');
		Route::post('/store','CategoryController@store')->name('categories.store');
		Route::get('/{id}/edit','CategoryController@edit')->name('categories.edit');
		Route::post('/update','CategoryController@update')->name('categories.update');
		Route::post('/search','CategoryController@search')->name('categories.search');
		Route::post('/destroy/{id}','CategoryController@destroy')->name('categories.destroy');
	});

	//products
	Route::prefix('products')->group(function(){
		Route::get('/','ProductController@index')->name('products.index');
		Route::get('/create','ProductController@create')->name('products.create');
		Route::post('/store', 'ProductController@store')->name('products.store');
		Route::get('/{id}/edit', 'ProductController@edit')->name('products.edit');
		Route::post('/{id}/update', 'ProductController@update')->name('products.update');
		Route::get('/{id}/show', 'ProductController@show')->name('products.show');
		Route::delete('/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
		Route::post('/search', 'ProductController@search')->name('products.search');
	});
	

});
