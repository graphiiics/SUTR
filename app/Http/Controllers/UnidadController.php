<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Unidad;
use Auth;

class UnidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	
    	$unidades = Unidad::orderBy('id', 'asc')->get();
    	return view('unidades/index',compact('unidades'));
    }

    public function editarUnidad(Unidad $unidad,Request $request)
    {
    	if($paciente->update(['nombre'=>$request->input('nombre'),'direccion'=>$request->input('direccion')])){

    	}else{

    	}
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/unidades');
	    		break;
	    	case 2:
	    		return redirect('admin/unidades');
	    		break;
	    	case 3:
	    		return redirect('gerente/unidades');
	    		break;
    	
   		}
    }
    public function guardarUnidad(Request $request)
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
