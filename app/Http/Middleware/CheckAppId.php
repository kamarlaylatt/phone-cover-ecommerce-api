<?php

namespace App\Http\Middleware;

use Closure;

class CheckAppId
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
        $request_user = $request->header('Application-User');
        $request_secret = $request->header('Application-Secret');
        $app_user = 'universitylife';
        $app_secret = '$Uni@Ver%$#sity&&^Life)((.p#ut%!uDFU&*pl2l654#**g<fd&%toter556217%%ss';
        if($request_user == $app_user && $request_secret == $app_secret)
        {
            return $next($request);
        }else{
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
            return response()->json($response,401);
        }


    }
}
