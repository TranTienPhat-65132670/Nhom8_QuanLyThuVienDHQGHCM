<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user_id')) {
            if (session('role') === 'admin') {
                return redirect()->route('admin_index');
            }
            return redirect()->route('client_index');
        }

        return $next($request);
    }
}
