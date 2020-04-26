<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ShellMaterialListResource;
use App\Http\Resources\RecruitmentListResource;
use App\Http\Resources\PhoneBrandListResource;
use App\Http\Resources\PhoneModelListResource;
use App\Http\Controllers\api\BaseController;
use App\ShellMaterial;
use App\Recruitment;
use App\PhoneBrand;
use App\PhoneModel;

class DiyController extends BaseController
{
    public function getShellMaterialList()
    {
        $responseBody = [
            'shellMaterialList' => ShellMaterialListResource::collection(ShellMaterial::all())
        ];

        return $this->successResponse($responseBody,'Successfully retrieve Shell Material List.');
    }

    public function getRecruitmentList()
    {
        $responseBody = [
            'recruitmentList' => RecruitmentListResource::collection(Recruitment::all())
        ];

        return $this->successResponse($responseBody,'Successfully retrieve Recruitment List.');
    }

    public function getPhoneBrandList()
    {
        $responseBody = [
            'phoneBrandList' => PhoneBrandListResource::collection(PhoneBrand::all())
        ];

        return $this->successResponse($responseBody,'Successfully retrieve Phone Brand List.');
    }

    public function getPhoneModelList(Request $request)
    {
        $responseBody = [
            'phoneModelList' => PhoneModelListResource::collection(PhoneModel::where('phone_brand_id', $request->phone_brand_id)->get())
        ];

        return $this->successResponse($responseBody,'Successfully retrieve Phone Model List.');
    }
}
