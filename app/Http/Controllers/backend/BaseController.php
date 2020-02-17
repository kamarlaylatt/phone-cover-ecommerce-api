<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BaseController extends Controller
{
    public function jsonValidate($request, $rules)
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
                'success' => false,
                'validation' => false,
                'responseMessage' => 'Multiple Error',
                'errors' => $errors_array,
            ];  
            
        }
        else{
        	return [
        		'success' => true,
        	];
        }
    }
}
