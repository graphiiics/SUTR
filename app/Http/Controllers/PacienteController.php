<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Paciente;
use App\Unidad;
use Auth;
use Session;

class PacienteController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
         switch (Auth::user()->tipo) {
            case 1:
                $pacientes= Paciente::all();
                $unidades=Unidad::all();
                break;
            case 2:
                $pacientes= Paciente::where('estatus','!=',3)->get();
                $unidades=Unidad::all();
                break;
            case 3:
                $pacientes= Paciente::where('unidad_id',Auth::user()->unidad_id)->where('estatus','!=',3)->get();
                break;
            case 4:
                $pacientes= Paciente::where('estatus','!=',3)->get();
                $unidades=Unidad::all();
                break;
        }
    	
    	return view('pacientes/index',compact('pacientes','unidades'));
    }

    public function editarPaciente(Paciente $paciente,Request $request)
    {
    	if($paciente->update($request->all())){
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
            case 4:
                return redirect('nutriologo/pacientes');
                break;
    	
   		}
    }
     public function suspenderPaciente(Paciente $paciente)
    {
        if($paciente->update(['estatus'=>2])){
             Session::flash('message','Paciente suspendido correctamente');
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
    public function activarPaciente(Paciente $paciente)
    {
        if($paciente->update(['estatus'=>1])){
             Session::flash('message','Paciente reactivado correctamente');
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
    public function eliminarPaciente(Paciente $paciente)
    {
        if($paciente->update(['estatus'=>3])){
             Session::flash('message','Paciente eliminado correctamente');
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
    public function pacientesUnidad(Request $request){
        if($request->input('id')==0){
            return Paciente::where('estatus',1)->orderBy('nombre','asc')->get();
        }else{
            return Unidad::find($request->input('id'))->pacientes;
        }
        
    }
}
