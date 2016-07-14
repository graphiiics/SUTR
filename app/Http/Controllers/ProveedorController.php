<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Proveedor;
use Session;
class ProveedorController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$proveedores = Proveedor::orderBy('id', 'asc')->get();
    	return view('proveedores/index',compact('proveedores'));
    }

    public function editarProveedor(Proveedor $proveedor, Request $request)
    {
    	if($proveedor->update(['nombre'=>$request->input('nombre'),'gerente'=>$request->input('gerente'),'telefono'=>$request->input('telefono'),'correo'=>$request->input('correo')])){
    		Session::flash('message','Proveedor actualizado correctamente');
	        Session::flash('class','success');
    	}
    	else{
    		Session::flash('message','Error al actualizar proveedor');
	        Session::flash('class','danger');
    	}
    return redirect('admin/proveedores');
    }

    public function guardarProveedor(Request $request){
    	$proveedor =new Proveedor($request->all());
    	if($proveedor->save()){
    		Session::flash('message','Proveedor guardado correctamente');
	        Session::flash('class','success');
    	}
    	else{
    		Session::flash('message','Error al guardar proveedor');
	        Session::flash('class','danger');
    	}
    	return redirect('admin/proveedores');
    }
    public function eliminarProveedor(Proveedor $proveedor)
    {
    	if(count($proveedor->productos)>0){
    		if($proveedor->productos()->detach()){
    			if($proveedor->delete()){
    				Session::flash('message','Proveedor eliminado correctamente');
	            	Session::flash('class','success');
	    		}else{
	    			Session::flash('message','Error al eliminar el proveedor');
	            	Session::flash('class','danger');
    		}
	    	}
	    	else{
	    		Session::flash('message','Error al eliminar los productos del proveedor');
	            Session::flash('class','danger');
	    	}
    	}
    	else{
    		if($proveedor->delete()){
    			Session::flash('message','Proveedor eliminado correctamente');
            	Session::flash('class','success');
    		}else{
    			Session::flash('message','Error al eliminar el proveedor');
            	Session::flash('class','danger');
    		}
    	}
    	return redirect('admin/proveedores');
    }
}
