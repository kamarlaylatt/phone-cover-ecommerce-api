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

Route::post('/images/upload','api\OrderController@imageUpload');

Route::namespace('api')->middleware('check_app')->group(function(){
    //Register
    Route::get('/send-otp', 'AuthController@sendOtp');
    Route::post('/register', 'AuthController@register');
    Route::post('/register/check-otp', 'AuthController@checkOtpRegister');
    Route::post('/login/provider', 'AuthController@providerLogin');
    Route::post('/login', 'AuthController@login');

    //home
    Route::prefix('home')->group(function(){
        Route::get('/banner/list', 'HomeController@getBannerList');
        Route::get('/category/list', 'HomeController@getCategoryList');
        Route::get('/product/list', 'HomeController@getProductList');
    });

    //languages
    Route::get('/language/list','BaseController@getLanguage');

    //categories
    Route::get('/category/root/list', 'CategoryController@getRootCategoryList');
    Route::get('/category/subcategory/list', 'CategoryController@getSubCategories');

    //products
    Route::get('/product/search', 'ProductController@searchProductList');
    Route::get('/product/list', 'ProductController@getProductList');
    Route::get('/product/detail', 'ProductController@getProductDetail');
    Route::get('/product/related-products', 'ProductController@getRelatedProduct');
    Route::get('/product/recommend-products', 'ProductController@getRecommendProduct');

    //DIY
    Route::get('/shell-material/list', 'DiyController@getShellMaterialList');
    Route::get('/recruitment/list', 'DiyController@getRecruitmentList');
    Route::get('/recruitment/detail', 'DiyController@getRecruitmentDetail');
    Route::get('/phone-brand/list', 'DiyController@getPhoneBrandList');
    Route::get('/phone-model/list', 'DiyController@getPhoneModelList');
    Route::get('/phone-model/detail', 'DiyController@getPhoneModelDetail');

    Route::get('/tab-list', 'DiyController@getTabList');
    Route::get('/charlet-list', 'DiyController@getCharletList');
    Route::get('/mask-list', 'DiyController@getMaskList');

    Route::middleware('auth:api')->group(function(){
        //logout
        Route::get('/logout', 'AuthController@logout');

        //profile
        Route::get('/profile', 'ProfileController@profile');
        Route::post('/profile/update', 'ProfileController@profileUpdate');

        //order
        Route::post('/order/product', 'OrderController@productOrder');
        Route::post('/order/intension', 'OrderController@intensionOrder');
        Route::get('/order-list', 'OrderController@orderList');
        Route::get('/order-detail', 'OrderController@orderDetail');
    });

});