<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->active_status != 1)
        {
            $response = [
                'responseCode' => 401,
                'responseMessage' => 'Invalid Session',
                'error' => [
                    [
                        'fieldCode' => 401,
                        'errorMessage' => 'Unauthorized: Access is denied due to invalid credentials',
                    ],                    
                ],
            ];
            return response()->json($response);
        }else{
            return $next($request);
        }
    }
}
