<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\BaseController;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Illuminate\Validation\Rule;

class AuthController extends BaseController
{
    public function sendOtp(Request $request)
    {
        // Send SMS
        $otp_code = mt_rand(1, 999999);
        // \Otp::sendSMS($user->phone, $otp_code);
        // $otp_code = '123456';  
        // $user->otp_code = $otp_code;
        // $user->save();
        $responseBody = [
            'phone' => $request->phone,
            'otp_code' => $otp_code,
        ];
        return $this->successResponse($responseBody, 'Successfully Send OTP');
    }

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
            'otp_code' => '1111',
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

    public function checkOtpRegister(Request $request)
    {
        $validation = $this->validateResponse($request->all(), ['phone' => 'required','otp_code' => 'required']);
		if($validation['validate_status'] == 1)
        {
            return $validation;
        }
        
        $user = User::where('phone',$request['phone'])->first();        

        if($user->otp_code == $request['otp_code'])
        {
            $user->active_status = 1;
            $user->save();

            $token =  $user->createToken('Customer')->accessToken;

            return response()->json([
                'responseCode' => 200,
                'responseMessage'=>'Correct Code No.',
                'responseBody' => [
                    // 'user_id' => $user->id,
                    // 'name' => $user->name,
                    // 'phone' => $user->phone,
                    // 'email' => $user->email,
                    // 'address' => $user->address,
                    // 'token' => $token,             
                ],
            ]);
        }
        else{
            $error = [
                [
                    'fieldCode' => 'invalid',
                    'errorMessage' => 'Sorry, invalid code number.',
                ],    
            ];
            return $this->failResponse($error);
        }
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

                $token =  $user->createToken('Customer')->accessToken;  

                return response()->json([ 
                    'responseCode' => 200,
                    'responseMessage' => 'Login Success',
                    'responseBody' => [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'email' => $user->email,
                        'address' => $user->address,
                        'token' => $token,  
                    ],
                ]);
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

    public function providerLogin(Request $request)
    {

        $user = User::where('provider_id', $request['provider_id'])
                    ->where('provider', $request['provider'])
                    ->first();

        if ($user) {

            $rules = [
                'name' => 'required',
                'provider' => 'required',
                'provider_id' => 'required',
                'phone' => ['required',Rule::unique('users')->ignore($user->id),],
            ];
    
            $validation = $this->validateResponse($request->all(), $rules);
            if($validation['validate_status'] == 1)
            {
                return $validation;
            }

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->save();

            $token =  $user->createToken('Customer')->accessToken;

            $responseBody = [
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'token' => $token,
            ];
            return $this->successResponse($responseBody, 'Successfully Login');

        } else {
            $rules = [
                'name' => 'required',
                'provider' => 'required',
                'provider_id' => 'required',
                'phone' => 'required|unique:users',
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
                'provider_id' => $request->provider_id,
                'provider' => $request->provider,
            ]);

            $token =  $user->createToken('Customer')->accessToken;

            $responseBody = [
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'token' => $token,
            ];
            return $this->successResponse($responseBody, 'Successfully Login');
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $data = [
            'logout_status' => 1,
        ];
        return $this->successResponse($data, 'Successfully Logout');
    }
}
