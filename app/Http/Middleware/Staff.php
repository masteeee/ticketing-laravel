<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Staff
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'staff') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized');
    }
}
