<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Gerente
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
                    return redirect('superAdmin');
                    break;
                #Administrador
                case '2':
                    return redirect('admin');
                    break;
                #Gerente
                case '3':
                    break;
                case '4':
                    return redirect('nutriologo');
                    break;
                default:
                   return  redirect('logout');
                    break;
            }
        }
        return $next($request);
    }
}
