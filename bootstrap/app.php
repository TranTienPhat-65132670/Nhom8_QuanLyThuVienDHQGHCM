<?php

use App\Http\Middleware\ClearPasswordResetSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withMiddleware(function (Middleware $middleware) {
        // dùng để xóa các session đổi mật khẩu khi họ đổi sang trang khác
        // dùng cho trường hợp nếu người dùng đang ở form đổi mật khẩu
        // mà đổi url thì session vẫn còn lưu
        $middleware->web(append: [
            ClearPasswordResetSession::class,
        ]);

        $middleware->alias([
            'check.login' => \App\Http\Middleware\CheckLogin::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'redirect.if.auth' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
