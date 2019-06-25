<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminUserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin_user')
    {
        // dd(Auth::guard($guard)->user());
        if (Auth::guard($guard)->guest()) {           
            return redirect('/admin');
        }

        return $next($request);
    }
}