<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('api')->group(function(){
    Route::prefix('home')->group(function(){
        Route::get('/banner/list', 'HomeController@getBannerList');
        Route::get('/category/list', 'HomeController@getCategoryList');
        Route::get('/product/list', 'HomeController@getProductList');
    });

    Route::get('/language/list','BaseController@getLanguage');
    Route::get('/category/root/list', 'CategoryController@getRootCategoryList');
});