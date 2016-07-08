<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class SuperAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            switch (Auth::user()->tipo) {
                #SuperAdministrador
                case '1':
                    break;
                #Administrador
                case '2':
                    return redirect('Admin');
                    break;
                #Gerente
                case '3':
                    return redirect('Gerente');
                    break;
                
                default:
                   return  redirect('logout');
                    break;
            }
        }
        return $next($request);
    }
}