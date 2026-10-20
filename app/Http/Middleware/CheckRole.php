<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if (session('role') !== $role) {
            if (session('role') === 'member') {
                return redirect()->route('member');
            }

            if (session('role') === 'admin') {
                return redirect()->route('admin');
            }
        }

        return $next($request);
    }
}
