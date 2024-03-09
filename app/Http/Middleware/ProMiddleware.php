<?php

namespace App\Http\Middleware;

use Closure;


class ProMiddleware
{
    public function handle($request, Closure $next)
    {
        $levelId = session('leveid');

        if ($levelId !== 'PRO' && $levelId !== 'ADMIN') {
            return response()->view('errors.unauthorized', [], 403);
        }

        return $next($request);
    }
}



