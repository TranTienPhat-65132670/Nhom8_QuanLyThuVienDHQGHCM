<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearPasswordResetSession
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isInResetFlow = $request->is('forgot-password*', 'verify-otp*', 'reset-password*');

        if (!$isInResetFlow) {
            session()->forget([
                'student_code',
                'otp_code',
                'otp_expires_at',
                'otp_verified',
                'otp_sent'
            ]);
        }

        return $next($request);
    }
}
