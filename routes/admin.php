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

Route::namespace('backend')->middleware('auth:admin')->group(function(){


	Route::get('/', function () {return redirect()->route('admins.profile');})->name('admin');

	//dashboard
	Route::get('/dashboard','DashboardController@index')->name('admins.dashboard');

	//admin profile
	Route::get('/profile', 'AdminController@profile')->name('admins.profile');
	Route::post('/profile/update', 'AdminController@profileUpdate')->name('admins.profile.update');
	Route::get('/edit/password', 'AdminController@editPassword')->name('admins.edit.password');
	Route::post('/update/password', 'AdminController@updatePassword')->name('admins.update.password');

	//only superadmin route group
	Route::middleware('check_admin')->group(function(){
		//admin_roles	
		Route::resource('admin_roles', 'AdminRoleController');
		Route::post('admin_roles/search', 'AdminRoleController@search')->name('admin_roles.search');
		
		//admins	
		Route::resource('admins', 'AdminController');
		Route::post('admins/search','AdminController@search')->name('admins.search');

		//users
		Route::resource('users', 'UserController');
		Route::get('block_list', 'UserController@block_list')->name('users.block_list');
		Route::post('users/{id}/block', 'UserController@block')->name('users.block');
		Route::post('users/{id}/unblock', 'UserController@unblock')->name('users.unblock');
		Route::post('users/search','UserController@search')->name('users.search');
		Route::post('users/block_search','UserController@block_search')->name('users.block_search');
	});	

	//shell_materials
	Route::resource('shell_materials', 'ShellMaterialController');
	Route::post('shell_materials/search','ShellMaterialController@search')->name('shell_materials.search');

	//phone_brands
	Route::resource('phone_brands', 'PhoneBrandController');
	Route::post('phone_brands/search','PhoneBrandController@search')->name('phone_brands.search');

	//phone_models
	Route::resource('phone_models', 'PhoneModelController');
	Route::post('phone_models/search','PhoneModelController@search')->name('phone_models.search');

	//recruitments
	Route::resource('recruitments', 'RecruitmentController');
	Route::post('recruitments/search', 'RecruitmentController@search')->name('recruitments.search');

	//banners
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

	//orders
	Route::prefix('orders')->group(function(){
		Route::get('/','OrderController@index')->name('orders.index');
	});

	//tabs
	Route::resource('tabs', 'TabController');
	Route::post('tabs/search','TabController@search')->name('tabs.search');

	//charlets
	Route::resource('charlets', 'CharletController');
	Route::post('charlets/search','CharletController@search')->name('charlets.search');

	//masks
	Route::resource('masks', 'MaskController');
	Route::post('masks/search','MaskController@search')->name('masks.search');
	

});
