<?php

namespace App\Http\Middleware;

use Closure;


class PhicMiddleware
{
    public function handle($request, Closure $next)
    {
        $levelId = session('leveid');

        if ($levelId !== 'PHIC') {
            return response()->view('errors.unauthorized', [], 403);
        }

        return $next($request);
    }
}



