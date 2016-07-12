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
