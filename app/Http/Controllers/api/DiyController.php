<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ShellMaterialListResource;
use App\Http\Resources\RecruitmentListResource;
use App\Http\Resources\RecruitmentDetailResource;
use App\Http\Resources\RecruitmentListResourceCollection;
use App\Http\Resources\PhoneBrandListResource;
use App\Http\Resources\PhoneModelListResource;
use App\Http\Resources\CharletListResource;
use App\Http\Resources\MaskListResource;
use App\Http\Controllers\api\BaseController;
use App\ShellMaterial;
use App\Recruitment;
use App\PhoneBrand;
use App\PhoneModel;
use App\Tab;
use App\Charlet;
use App\Mask;

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
        return new RecruitmentListResourceCollection(Recruitment::paginate(10));
    }

    public function getRecruitmentDetail(Request $request)
    {
        $recruitment = Recruitment::find($request->recruitment_id);
        if($recruitment)
        {
            $responseBody = new RecruitmentDetailResource($recruitment);
        }
        else{
            $responseBody = null;
        }
        return $this->successResponse($responseBody,'Successfully retrieve Recruitment Detail.');
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

    public function getTabList()
    {
        $tabs = Tab::select('id as tabId','name')->get();

        $responseBody = [
            'tabList' => $tabs,
        ];
        return $this->successResponse($responseBody,'Successfully retrieve Tab List.');
    }

    public function getCharletList()
    {
        $responseBody = [
            'charletList' => CharletListResource::collection(Charlet::all()),
        ];
        return $this->successResponse($responseBody,'Successfully retrieve Charlet List.');
    }

    public function getMaskList()
    {
        $responseBody = [
            'maskList' => MaskListResource::collection(Mask::all()),
        ];
        return $this->successResponse($responseBody,'Successfully retrieve Mask List.');
    }
}
