<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->user_level !== 'Admin') {
            return response()->view('errors.unauthorized', [], 403);
        }

        return $next($request);
    }
}


