<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Http\Resources\Home\CategoryListResource;
use App\Http\Resources\Home\ProductListResource;
use App\Http\Resources\Home\BannerListResource;
use App\Banner;
use App\Category;
use App\Product;

class HomeController extends BaseController
{
    public function getBannerList()
    {
        $responseBody = [
            'bannerList' => BannerListResource::collection(Banner::inRandomOrder()->where('show_status',1)->get()),
        ];
        return $this->successResponse($responseBody, 'Success retrieve banner list');
    }

    public function getCategoryList()
    {
        $responseBody = [
            'categoryList' => CategoryListResource::collection(Category::inRandomOrder()->limit(6)->get()),
        ];
        return $this->successResponse($responseBody, 'Success retrieve category list');
    }

    public function getProductList()
    {
        $responseBody = [
            'productList' => ProductListResource::collection(Product::inRandomOrder()->limit(20)->get()),
        ];
        return $this->successResponse($responseBody, 'Success retrieve product list');
    }
}
