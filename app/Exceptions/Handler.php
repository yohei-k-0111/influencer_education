<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * Handle unauthenticated users.
     * 
     * @parm \Illuminate\http\Request $request
     * @parm \Throwable $exception
     * @return \Illminate\http\responese
     */
    protected function unauthenticated($request, Throwable $exception) //認証していない状態で認証が必要なページにアクセスするとログインページに飛ばされる
    {
        if($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }
        if($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin/login');
        }
        return redirect()->guest($exception->redirectTo ?? route('login'));
    }
}
