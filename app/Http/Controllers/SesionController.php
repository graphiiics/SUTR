<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Recibo;
use App\Unidad;
use App\Paciente;
use App\Beneficio;
use Auth;
use Session;
use App\Sesion;


class SesionController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $d=strtotime("-6 Months");
        switch (Auth::user()->tipo) {
            case 1:
                $sesiones = Sesion::where('fecha','>',date("Y-m-d", $d))->orderBy('fecha', 'asc')->get();
                break;
            case 2:
                $sesiones = Sesion::where('fecha','>',date("Y-m-d", $d))->orderBy('fecha', 'asc')->get();
                break;
            case 3:
                $sesiones = Sesion::where('updated_at','>',date('Y-m-d'))->where('user_id',Auth::user()->id)->orderBy('fecha', 'asc')->get();
                
                break;
        }
    	
    	return view('sesiones/index',compact('sesiones'));
    }
}
