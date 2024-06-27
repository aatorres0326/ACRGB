<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated based on session data
        if (Session::has('userid') && Session::has('token')) {
            return $next($request);
        }

        // If not authenticated, redirect to the login page
        return redirect('/login');
    }
}