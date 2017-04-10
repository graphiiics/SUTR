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
use Session;


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

    public function editarBeneficio(Beneficio $beneficio,Request $request)
    {
    	if($beneficio->sesiones_realizadas>0){
            Session::flash('message','Ya no se puede modificar este Beneficio');
            Session::flash('class','danger');
        }
        else{
            if($beneficio->update(['cantidad'=>$request->input('cantidad'),'sesiones'=>$request->input('sesiones')])){
                Session::flash('message','Beneficio actualizado correctamente');
                Session::flash('class','success');
            }else{
                Session::flash('message','No se pudo actualizar el beneficio');
                Session::flash('class','danger');
            }
        }
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/beneficios');
	    		break;
	    	case 2:
	    		return redirect('admin/beneficios');
	    		break;
	    	case 3:
	    		return redirect('gerente/beneficios');
	    		break;
    	
   		}
    }
    
    public function guardarBeneficio(Request $request)
    {
    	$beneficio= new Beneficio($request->all());
        $beneficio->fecha=date('Y-m-d');
        $beneficio->user_id=Auth::user()->id;
    	$beneficio->estatus=1;
    	if($beneficio->save()){
            Session::flash('message','Beneficio creado correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','No se pudo crear el beneficio');
            Session::flash('class','danger');
        }
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/beneficios');
	    		break;
	    	case 2:
	    		return redirect('admin/beneficios');
	    		break;
	    	case 3:
	    		return redirect('gerente/beneficios');
	    		break;
    	
   		}
   	}

    public function eliminarBeneficio(Beneficio $beneficio){
        if($beneficio->sesiones_realizadas<1){
            $beneficio->delete();
            Session::flash('message','Beneficio eliminado correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','No se pudo eliminar el beneficio');
            Session::flash('class','danger');
        }
        switch (Auth::user()->tipo) {
            case 1:
                return redirect('superAdmin/beneficios');
                break;
            case 2:
                return redirect('admin/beneficios');
                break;
            case 3:
                return redirect('gerente/beneficios');
                break;
        
        }
    }
}
