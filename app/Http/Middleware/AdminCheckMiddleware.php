<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheckMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user is an admin
            if (Auth::user()->isAdmin()) {
                return $next($request);
            }
        }

        // If not an admin, redirect to the regular user's home
        return redirect('/home');
    }
}
