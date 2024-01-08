<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    protected $dontReport = [
        //
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        return false;
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json([
                'success' => false,
                'code'=> 401,
                'locale'=> 'en',
                'message'=> 'Unauthorized',
                'data'=>''
            ],Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof TokenExpiredException) {
            return response()->json([
                'success' => false,
                'code'=> 401,
                'locale'=> 'en',
                'message'=> 'Unauthorized expired token',
                'data'=>''
            ],Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof JWTException) {
            return response()->json([
                'success' => false,
                'code'=> 401,
                'locale'=> 'en',
                'message'=> 'Not Unauthorized',
                'data'=>''
            ],Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof UnauthorizedException) {
            return response()->json([
                'success' => false,
                'code'=> 403,
                'locale'=> 'en',
                'message'=> 'You are not authorized to perform this action.',
                'data'=>''
            ], Response::HTTP_FORBIDDEN);
        }
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'code'=> 404,
                'locale'=> 'en',
                'message'=> 'Resource not found',
                'data'=>''
            ], Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof HttpResponseException) {
            return response()->json([
                'success' => false,
                'code'=> 400,
                'locale'=> 'en',
                'message'=> 'Invalid request',
                'data'=>''
            ], Response::HTTP_BAD_REQUEST);
        }
        return parent::render($request, $exception);
        //
    }
}
