<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\BaseController;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Illuminate\Validation\Rule;

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
}
