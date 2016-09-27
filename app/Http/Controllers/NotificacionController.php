<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Notificacion;
use Auth;
use Session;

class NotificacionController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$notificaciones=Notificacion::where('user_id',Auth::user()->id)->where('estado',2)->get();
    	return view('notificaciones/index',compact('notificaciones'));
    }

    public function suspenderNotificacion(Notificacion $notificacion)
    {
    	$notificacion->update(['estado'=>1]);
    	switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/notificaciones');
            break;
         case 2:
               return redirect('admin/notificaciones');
            break;
        case 3:
                return redirect('gerente/notificaciones');
            break;
       }
    }
}
