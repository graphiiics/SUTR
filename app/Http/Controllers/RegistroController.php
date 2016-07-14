<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Registro;
use App\Producto;
use Session;
use Auth;

class RegistroController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$registros = Registro::orderBy('id', 'asc')->get();
    	$productos = Producto::orderBy('id', 'asc')->get();
    	return view('registros/index',compact('registros','productos'));
    }

    public function guardarRegistro(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$registro= new Registro;
	    	$registro->user_id=Auth::user()->id;
	    	$registro->unidad_id=$request->input('unidad');
	    	$registro->fecha=date('Y-m-d H:i:s');
	    	$registro->tipo=$request->input('tipo');
    		if($registro->save()){
	    		for ($i=0; $i <intval($request->input('totalProductos')); $i++) { 
	    			    $registro->productos()->attach($registro->id,['producto_id' =>$request->input('producto'.($i+1)),'cantidad' =>$request->input('cantidad'.($i+1)),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
	    		}
	    		Session::flash('message','Registro realizado correctamente');
		        Session::flash('class','success');
	    	}else{
	    		Session::flash('message','Error al crear el registro');
		        Session::flash('class','danger');
	    	}
    	}else{
    		session::flash('message','El registro no contiene ningún producto');
		    Session::flash('class','danger');
    	}
    	
    	return redirect('admin/registros');
    	// return $request->all();
    }

    public function eliminarRegistro( Registro $registro){
    	if(count($registro->productos)>0){
    		if($registro->productos()->detach()){
    			if($registro->delete()){
    				Session::flash('message','Pedido eliminado correctamente');
	            	Session::flash('class','success');
	    		}else{
	    			Session::flash('message','Error al eliminar el registro');
	            	Session::flash('class','danger');
    		}
	    	}
	    	else{
	    		Session::flash('message','Error al eliminar los productos del registro');
	            Session::flash('class','danger');
	    	}
    	}
    	else{
    		if($registro->delete()){
    			Session::flash('message','Registro eliminado correctamente');
            	Session::flash('class','success');
    		}else{
    			Session::flash('message','Error al eliminar el registro');
            	Session::flash('class','danger');
    		}
    	}
    	
    	return redirect('admin/registros');
    }
}
