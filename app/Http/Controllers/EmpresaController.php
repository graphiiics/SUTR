<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\Empresa;

class EmpresaController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$empresas = Empresa::orderBy('razon_social', 'asc')->get();
    	return view('empresas/index',compact('empresas'));
    }
    public function guardarEmpresa(Request $request){
    	$empresa= new Empresa($request->all());
    	if($empresa->save()){
    		Session::flash('message','Empresa registrada correctamente');
		    Session::flash('class','success');
    	}
    	else{
    		Session::flash('message','Error al registrar la empresa');
		    Session::flash('class','danger');
    	}

    	return redirect('admin/empresas');
    }

    public function editarEmpresa(Empresa $empresa,Request $request){
    	if($empresa->update($request->all())){
    		Session::flash('message','Empresa registrada correctamente');
		    Session::flash('class','success');
    	}
    	else{
    		Session::flash('message','Error al registrar la empresa');
		    Session::flash('class','danger');
    	}

    	return redirect('admin/empresas');
    }
}
 