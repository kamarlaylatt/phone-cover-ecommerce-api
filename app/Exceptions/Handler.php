<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Auth; 
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        // is this request asks for api?
        if( $request->is('api/*') || $request->header('content-type','application/json')){

            /*  is this exception? */

            if ( !empty($exception) ) {

                // set default error message
                $response = [
                    'responseCode' => 500,
                    'responseMessage' => 'Internal server error',
                    'error' => [
                        [
                            'fieldCode' => '400',
                            'errorMessage' => $exception->getMessage(),
                        ],                    
                    ],
                ];

                

                $status = 400;

                // get correct status code

                // is this validation exception
                if($exception instanceof ValidationException){

                    return $this->convertValidationExceptionToResponse($exception, $request);

                    // is it authentication exception
                }else if($exception instanceof AuthenticationException){

                    $status = 401;

                    $response = [
                        'responseCode' => 401,
                        'responseMessage' => 'Invalid Session',
                        'error' => [
                            [
                                'fieldCode' => $status,
                                'errorMessage' => 'Unauthorized: Access is denied due to invalid credentials',
                            ],                    
                        ],
                    ];

                    //is it DB exception
                }else if($exception instanceof \PDOException){

                    $status = 500;

                    $response = [
                        'responseCode' => 500,
                        'responseMessage' => 'Internal server error',
                        'error' => [
                            [
                                'fieldCode' => $status,
                                'errorMessage' => $exception->getMessage(),
                            ],                    
                        ],
                    ];

                    // is it http exception (this can give us status code)
                }else if($this->isHttpException($exception)){

                    $status = $exception->getStatusCode();

                    $response = [
                        'responseCode' => 500,
                        'responseMessage' => 'Invalid request',
                        'error' => [
                            [
                                'fieldCode' => $status,
                                'errorMessage' => 'not found this request',
                            ],                    
                        ],
                    ];

                }else{

                    // for all others check do we have method getStatusCode and try to get it
                    // otherwise, set the status to 400
                    $status = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 400;

                }

                return response()->json($response,$status);

            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin/login');
        }
        return redirect()->guest(route('login'));
    }
}
