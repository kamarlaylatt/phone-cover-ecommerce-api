<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserProfileResource;
use App\Http\Controllers\api\BaseController;
use Auth;
use App\User;
use Illuminate\Validation\Rule;

class ProfileController extends BaseController
{
    public function profile()
    {
        $responseBody = new UserProfileResource(User::findOrFail(Auth::user()->id));
        return $this->successResponse($responseBody, 'Success retrieve user profile.');
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $rules = [
            'name' => 'required',
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
        $user->address = $request->address;
        $user->save();

        $responseBody = new UserProfileResource(User::findOrFail(Auth::user()->id));
        return $this->successResponse($responseBody, 'Successfully update user profile.');
    }
}
