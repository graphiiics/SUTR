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
    	if($paciente->update(['nombre'=>$request->input('nombre'),'direccion'=>$request->input('direccion'),'telefono'=>$request->input('telefono'),'celular'=>$request->input('celular'),'unidad'=>$request->input('unidad')])){
             Session::flash('message','Datos del paciente actualizados correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Error al actuaizar datos del paciente');
            Session::flash('class','danger');
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
            Session::flash('message','Paciente registrado correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Error al registrar paciente');
            Session::flash('class','danger');
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
