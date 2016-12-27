<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Beneficio;
use App\Unidad;
use App\Paciente;
use App\Empresa;
use App\Concepto;
use Auth;

class BeneficioController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
       $d=strtotime("-6 Months");
        $empresas=Empresa::all();
        $conceptos=Concepto::all();
        switch (Auth::user()->tipo) {
            case '1':
               $beneficios=Beneficio::where('fecha','>',date("Y-m-d", $d))->orderBy('id','des')->get();
               $pacientes=Paciente::orderBy('nombre', 'asc')->where('estatus',1)->get();
                $unidades=Unidad::all();
                return view('beneficios/index',compact('beneficios','unidades','pacientes','empresas','conceptos'));
                break;
            case '2':
               $beneficios=Beneficio::where('fecha','>',date("Y-m-d", $d))->orderBy('id','des')->get();
               $pacientes=Paciente::orderBy('nombre', 'asc')->where('estatus',1)->get();
                $unidades=Unidad::all();
                return view('beneficios/index',compact('beneficios','unidades','pacientes','empresas','conceptos'));
                break;
            case '3':
                $beneficios= Beneficio::where('unidad_id',Auth::user()->unidad_id)->where('fecha','>',date("Y-m-d", $d))->orderBy('id','des')->get();
                $pacientes=Paciente::where('unidad_id',Auth::user()->unidad_id)->where('estatus',1)->orderBy('nombre', 'asc')->get();
                return view('beneficios/index',compact('beneficios','pacientes','empresas','conceptos'));
                break;
        }
       
    	
    }

    // public function editarPaciente(Paciente $paciente,Request $request)
    // {
    // 	if($paciente->update(['nombre'=>$request->input('nombre'),'direccion'=>$request->input('direccion'),'telefono'=>$request->input('telefono'),'celular'=>$request->input('celular'),'unidad'=>$request->input('unidad')])){

    // 	}else{

    // 	}
    // 	switch (Auth::user()->tipo) {
	   //  	case 1:
	   //  		return redirect('superAdmin/pacientes');
	   //  		break;
	   //  	case 2:
	   //  		return redirect('admin/pacientes');
	   //  		break;
	   //  	case 3:
	   //  		return redirect('gerente/pacientes');
	   //  		break;
    	
   	// 	}
    // }
    
    public function guardarBeneficio(Request $request)
    {
    	$beneficio= new Beneficio($request->all());
        $beneficio->fecha=date('Y-m-d');
        $beneficio->user_id=Auth::user()->id;
    	$beneficio->estatus=1;
    	if($beneficio->save()){

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
