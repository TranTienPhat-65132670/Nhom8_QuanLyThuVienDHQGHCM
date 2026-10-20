<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // kiểm tra người dùng có session không
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập!');
        }

        return $next($request);
    }
}
