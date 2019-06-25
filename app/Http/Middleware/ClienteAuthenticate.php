<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClienteAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'cliente')
    {

        if (Auth::guard($guard)->guest()) {            
            return redirect()->route("loja.login");
        }
        
        if( Auth::guard($guard)->check() ){
            if( $request->session()->get('session_id') === null )
                $request->session()->put('session_id', date('Ymd.His'));
        }

        return $next($request);
    }
}