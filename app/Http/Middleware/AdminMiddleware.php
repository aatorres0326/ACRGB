<?php

namespace App\Http\Middleware;

use Closure;


class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session()->has('leveid') && session('leveid') !== 'ADMIN') {
            return response()->view('errors.unauthorized', [], 403);
        }

        return $next($request);
    }
}


