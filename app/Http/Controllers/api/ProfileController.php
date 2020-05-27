<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserProfileResource;
use App\Http\Controllers\api\BaseController;
use Auth;
use App\User;

class ProfileController extends BaseController
{
    public function profile()
    {
        $responseBody = new UserProfileResource(User::findorFail(Auth::user()->id));
        return $this->successResponse($responseBody, 'Success retrieve user profile.');
    }
}
