<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Throwable;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            if ($exception instanceof TokenExpiredException) {
                return response()->json(["error" => "Token Expired", "StatusCode" => 401]);
            } else if ($exception instanceof TokenInvalidException) {
                return response()->json(["error" => "Token Invalid", "StatusCode" => 401]);
            } else if ($exception instanceof JWTException) {
                return response()->json(["error" => "Token Not Found", "StatusCode" => 401]);
            } else if ($exception instanceof UnauthorizedHttpException) {
                return response()->json(["error" => "Error fetching token", "StatusCode" => 401]);
            }
            else if ($exception instanceof TokenMismatchException) {
                return response()->json(["error" => "Token Mismatch", "StatusCode" => 401]);
            }
        }
        return parent::render($request, $exception);
    }
}
