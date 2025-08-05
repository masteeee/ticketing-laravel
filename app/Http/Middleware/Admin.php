<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'admin') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Unauthorized.');
    }
}
