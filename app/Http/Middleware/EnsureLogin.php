<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && in_array($request->route()->getName(), ['signin', 'signup', 'verifyotp'])) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
