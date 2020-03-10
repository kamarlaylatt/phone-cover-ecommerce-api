<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LanguageResource;
use App\Language;

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

    public function getLanguage(){
        $responseBody = [
            'language' => LanguageResource::Collection(Language::all()),
        ];

        return $this->successResponse($responseBody, 'Successfully retrieve language list');
    }
}
