<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Paciente;
use App\Unidad;
use Auth;

class PacienteController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
       
    	$pacientes= Paciente::all();
        $unidades=Unidad::all();
    	return view('pacientes/index',compact('pacientes','unidades'));
    }
    public function editarPaciente(Paciente $paciente,Request $request)
    {
    	if($paciente->update(['nombre'=>$request->input('nombre'),'direccion'=>$request->input('direccion'),'telefono'=>$request->input('telefono'),'unidad'=>$request->input('unidad')])){

    	}else{

    	}
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/pacientes');
	    		break;
	    	case 2:
	    		return redirect('admin/pacientes');
	    		break;
	    	case 3:
	    		return redirect('gerente/pacientes');
	    		break;
    	
   		}
    }
    public function guardarPaciente(Request $request)
    {
    	$paciente= new Paciente($request->all());
    	$paciente->estatus=1;
    	if($paciente->save()){

    	}else{

    	}
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/pacientes');
	    		break;
	    	case 2:
	    		return redirect('admin/pacientes');
	    		break;
	    	case 3:
	    		return redirect('gerente/pacientes');
	    		break;
    	
   		}
    }
}
