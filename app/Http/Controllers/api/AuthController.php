<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\BaseController;
use Illuminate\Http\Request;
use App\User;
use Hash;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required',
        ];

        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
        }

         //check unique order no
         $check = false;
         $uuid = 0;
         while($check == false){
             $uuid = time();
             $check_no = User::where('uuid',$uuid)->first();
             if(!$check_no)
             {
                 $check = true;
             }
             else{
                 $check = false;
             }
         }
         //end check

        $user = User::create([
            'name' => $request->name,
            'uuid' => $uuid,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        // Send SMS
        // $otp_code = mt_rand(1, 999999);
        // \Otp::sendSMS($user->phone, $otp_code);
        // $otp_code = '123456';  
        // $user->otp_code = $otp_code;
        // $user->save();

        

        $token =  $user->createToken('Customer')->accessToken;
        
        $responseBody = [
            'user_id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'address' => $user->address,
            'token' => $token,
        ];
        return $this->successResponse($responseBody, 'Successfully Register');
    }

    public function login(Request $request)
    {

        $rules = [
            'phone' => 'required|numeric',
            'password' => 'required',
        ];

        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
        }

        $user = User::where('phone', $request['phone'])->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                // $tokens = $user->tokens();
                // foreach($tokens as $token) {
                //     $token->revoke();   
                // }


                $token =  $user->createToken('Customer')->accessToken;
                // $user->device_type = $request['deviceType'];
                // $user->mobile_fcm_token = $request['fcmToken'];
                // $user->save();

                $responseBody = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $user->address,
                    'token' => $token,
                ];
                return $this->successResponse($responseBody, 'Successfully Login');

            } else {
                $error = [
                    [
                        'fieldCode' => 'password',
                        'errorMessage' => 'Password does not match',
                    ],    
                ];
                return $this->failResponse($error);
            }

        } else {
                $error = [
                    [
                        'fieldCode' => 'phone',
                        'errorMessage' => 'Invalid Phone',
                    ],   
                ];
                return $this->failResponse($error);
        }
    }
}
