<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch (Auth::user()->tipo) {
                #SuperAdministrador
                case '1':
                    return redirect('superAdmin');
                    break;
                #Administrador
                case '2':
                    return redirect('admin');
                    break;
                #Gerente
                case '3':
                    return redirect('gerente');
                    break;
                
                default:
                   return  redirect('logout');
                    break;
            }
        }

        return $next($request);
    }
}
