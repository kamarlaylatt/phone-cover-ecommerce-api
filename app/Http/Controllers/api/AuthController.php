<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\BaseController;
use Illuminate\Http\Request;
use App\User;
use App\OtpCheck;
use Hash;
use Illuminate\Validation\Rule;
use Auth;

class AuthController extends BaseController
{
    public function sendSMS($phone, $otp_code)
    {
        // SMSPoh Authorization Token
        $token = "5yZ_hGEas-RiQcLp1uGyUAfCS0kREHbPuDPk_NQvVfPB7BWZ7uN08K86Ni-VGM74";

        // // Prepare data for POST request
        $data = [
            "to"        =>      "$phone",
            "message"   =>      "Your UNIVERSITYLIFE OTP is $otp_code. DO NOT! share it to anyone. Call the Customer Care Center +09263683288 if OTP was not requested by you.",
            "sender"    =>      "UNIVERSITYLIFE"
        ];
        $ch = curl_init("https://smspoh.com/api/v2/send"); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
    }

    public function sendOtp(Request $request)
    {
        $rules = [
            'phone' => 'required',
        ];

        $validation = $this->validateResponse($request->all(), $rules);
        if($validation['validate_status'] == 1)
        {
            return $validation;
        }

        $otp_code = mt_rand(100000, 999999);
        $otp_check = OtpCheck::where('phone', $request->phone)->first();
    
        if($otp_check)
        {
            $otp_check->otp_code = $otp_code;
            $otp_check->save();
        }else{
            $otp_check = OtpCheck::Create([
                'phone' => $request->phone,
                'otp_code' => $otp_code,
            ]);
        }
        
        // Send SMS
        // $this->sendSMS($request->phone, $otp_code);
        // $otp_code = '123456';  
        // $user->otp_code = $otp_code;
        // $user->save();

        $responseBody = [
            'phone' => $otp_check->phone,
            'otp_code' => $otp_check->otp_code,
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
            'active_status' => 1,
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
        
        $otp_check = OtpCheck::where('phone',$request['phone'])->first();        

        if($otp_check->otp_code == $request['otp_code'])
        {


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

    public function changePassword(Request $request)
	{
		$rules = [
			'oldPassword' => 'required',
			'newPassword' => 'required|same:confirmPassword',
			'confirmPassword' => 'required',
		];
		$validation = $this->validateResponse($request->all(), $rules);
		if($validation['validate_status'] == 1)
        {
            return $validation;
        }

		
		$oldPassword = $request['oldPassword'];
		$newPassword = $request['newPassword'];
		$confirmPassword = $request['confirmPassword'];

		$user = Auth::user();
		$userPassword = $user->password;

		if($oldPassword == $newPassword)
		{
			$errors = [
				[
					'fieldCode' => 'must different',
					'errorMessage' => 'Your new password cannot be the same as your current password, please try again',
				],
			];
			return $this->failResponse($errors);
		}


		if(Hash::check($request->oldPassword, $user->password))
		{
			$user->password = Hash::make($newPassword);
			$user->save();

			$responseBody = [
				'userId' => Auth::user()->id,
				'userName' => Auth::user()->name,
				'userPhone' => Auth::user()->phone,
				'message' => 'Successfully update password.',
			];
		
			return $this->successResponse($responseBody, 'Successfully update password.');
		}
		else{
			$errors = [
				[
					'fieldCode' => 'notMatch',
					'errorMessage' => 'Your old password not match, please try again',
				],
			];
			return $this->failResponse($errors);
		}
    }
    
    public function forgotPassword(Request $request)
    {
        $validation = $this->validateResponse($request->all(), ['phoneNo' => 'required']);
		if($validation['validate_status'] == 1)
        {
            return $validation;
		}
		
		$phone_no = $request['phoneNo'];

		if(User::where('phone', $phone_no)->exists())
		{ 
            $otp_code = mt_rand(100000, 999999);
            $otp_check = OtpCheck::where('phone', $request->phoneNo)->first();
        
            if($otp_check)
            {
                $otp_check->otp_code = $otp_code;
                $otp_check->save();
            }else{
                $otp_check = OtpCheck::Create([
                    'phone' => $request->phoneNo,
                    'otp_code' => $otp_code,
                ]);
            }

            // Send SMS
            // $this->sendSMS($request->phone, $otp_code);
            // $otp_code = '123456';  
            // $user->otp_code = $otp_code;
            // $user->save();

            $user = User::where('phone', $phone_no)->first();

            $responseBody = [
                'user_id' => $user->id,
                'phone' => $otp_check->phone,
                'otp_code' => $otp_check->otp_code,
            ];
            return $this->successResponse($responseBody, 'Successfully check forget phone no and Send OTP');
		}
		else{
			$errors = [
				[
					'fieldCode' => 'invalid',
					'errorMessage' => 'Phone no is invalid',
				],
			];
			return $this->failResponse($errors);
		}
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'userId' => 'required',
            'newPassword' => 'required|same:confirmPassword',
            'confirmPassword' => 'required',
        ];
        $validation = $this->validateResponse($request->all(), $rules);
		if($validation['validate_status'] == 1)
        {
            return $validation;
        }

        $user = User::findOrFail($request['userId']);
        $token =  $user->createToken('unilife')->accessToken;

        $new_password= Hash::make($request['newPassword']);
        $user->password = $new_password;
        $user->save();

        return response()->json([
            'responseCode' => 1,
            'responseMessage'=>'Successfully reset password',
            'responseBody' => [
                'userId' => $user->id,
                'token' => $token,
            ],                
        ]);
    }
}
