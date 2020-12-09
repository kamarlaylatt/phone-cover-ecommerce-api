<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Region;
use App\Township;

class RegionController extends BaseController
{
    public function getRegionList(Request $request)
    {
        $responseBody = [
            'region_lists' => Region::all()->map(function($region)use($request){
                return [
                    'region_id' => $region->id,
                    'name' => $region->region_infos->where('language_id', $request->language_id)->first()->name,
                ];
                
            }),
        ];
        return $this->successResponse($responseBody, 'Success retrieve region list.');
    }

    public function getTownshipList(Request $request)
    {
        
        $responseBody = [
            'township_lists' => Township::where('region_id', $request->region_id)->get()
            ->map(function($township)use($request){
                return [
                    'township_id' => $township->id,
                    'name' => $township->township_infos->where('language_id', $request->language_id)->first()->name,
                    'delivery_price' => $township->delivery_price
                ];
                
            }),
        ];
        return $this->successResponse($responseBody, 'Success retrieve township list.');
    }

}
