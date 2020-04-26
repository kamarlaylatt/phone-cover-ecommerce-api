<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LanguageResource;
use App\Language;
use Validator;

class BaseController extends Controller
{
    public function successResponse($data, $message)
    {
        $response = [
            'responseCode' => 200,
            'responseMessage' => $message,
            'responseBody' => $data,
        ];

        return response()->json($response, 200);
    }

    public function failResponse($errors)
    {
        $response = [
            'responseCode' => 404,
            'responseMessage' => 'multiple errors',
            'error' => $errors,
        ];

        return response()->json($response, 200);
    }

    public function validateResponse($request, $rules)
    {
    	$validator = Validator::make($request, $rules);

        if($validator->fails()){
            
            $errors_array = array(); 

            $errors = $validator->errors();

            foreach ($errors->all() as $error) {
                $error_array = explode(" ", $error);
                $data = [
                    "fieldCode" => $error_array[1],
                    "errorMessage" => $error,
                ];

                array_push($errors_array, $data);
            }

            return [
                'responseCode' => 1000,
                'responseMessage' => 'Multiple Error',
                'validate_status' => 1,
                'error' => $errors_array,

            ];  
            
        }else{
            return [
                'validate_status' => 0,
            ];  
        }
    }

    public function getLanguage(){
        $responseBody = [
            'language' => LanguageResource::Collection(Language::all()),
        ];

        return $this->successResponse($responseBody, 'Successfully retrieve language list');
    }
}
