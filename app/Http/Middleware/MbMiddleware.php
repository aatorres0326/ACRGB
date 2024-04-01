<?php

namespace App\Http\Middleware;

use Closure;


class MbMiddleware
{
    public function handle($request, Closure $next)
    {
        $levelId = session('leveid');

        if ($levelId !== 'PRO' && $levelId !== 'ADMIN' && $levelId !== 'MB' && $levelId !== 'PHIC') {
            return response()->view('errors.unauthorized', [], 403);
        }

        return $next($request);
    }
}



