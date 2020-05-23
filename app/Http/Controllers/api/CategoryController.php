<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\SubCategoryListResource;
use App\Category;

class CategoryController extends BaseController
{
    public function getRootCategoryList()
    {
        $responseBody = [
            'rootCategoryList' => CategoryListResource::collection(Category::where('parents', 0)->get()),
        ];

        return $this->successResponse($responseBody, 'Success retrieve cateogory root list');
    }

    public function getSubCategories(Request $request)
    {
        $responseBody = [
            'subCategoryList' => SubCategoryListResource::collection(Category::where('parents', $request->category_id)->get()),
        ];

        return $this->successResponse($responseBody, 'Success retrieve cateogory root list');
    }
}
