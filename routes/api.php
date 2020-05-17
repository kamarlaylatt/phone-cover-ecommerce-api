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

Route::namespace('api')->middleware('check_app')->group(function(){
    Route::prefix('home')->group(function(){
        Route::get('/banner/list', 'HomeController@getBannerList');
        Route::get('/category/list', 'HomeController@getCategoryList');
        Route::get('/product/list', 'HomeController@getProductList');
    });

    Route::get('/language/list','BaseController@getLanguage');
    Route::get('/category/root/list', 'CategoryController@getRootCategoryList');
    Route::get('/category/subcategory/list', 'CategoryController@getSubCategories');
    Route::get('/product/list', 'ProductController@getProductList');
    Route::get('/product/detail', 'ProductController@getProductDetail');

    Route::get('/shell-material/list', 'DiyController@getShellMaterialList');
    Route::get('/recruitment/list', 'DiyController@getRecruitmentList');
    Route::get('/phone-brand/list', 'DiyController@getPhoneBrandList');
    Route::get('/phone-model/list', 'DiyController@getPhoneModelList');

    //order
    Route::post('/order/product', 'OrderController@productOrder');

    Route::get('/tab-list', 'DiyController@getTabList');
    Route::get('/charlet-list', 'DiyController@getCharletList');
    Route::get('/mask-list', 'DiyController@getMaskList');

});