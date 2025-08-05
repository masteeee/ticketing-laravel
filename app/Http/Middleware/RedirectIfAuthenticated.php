<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                // if ($user->role === 'admin' || $user->role->name === 'admin') {
                return redirect('/admin/dashboard');
                // } elseif ($user->role === 'staff' || $user->role->name === 'staff') {
                    // return redirect('/staff/dashboard');
                // }
                // return redirect('/');
            }
        }

        return $next($request);
    }
}
