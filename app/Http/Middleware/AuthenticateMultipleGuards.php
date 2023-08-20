<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateMultipleGuards
{
    public function handle($request, Closure $next, ...$guards)
    {
        $authenticated = false;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $authenticated = true;
                break;
            }
        }

        if (!$authenticated) {
            // Helper::alert('error', 'Anda tidak diizinkan mengakses halaman ini', '');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
