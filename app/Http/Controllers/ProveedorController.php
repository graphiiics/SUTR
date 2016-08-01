<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Proveedor;
use App\Producto;
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
    public function productosProveedores(){
        $productos = Producto::orderBy('id', 'asc')->get();
        $proveedores = Proveedor::orderBy('id', 'asc')->get();
        return view('proveedores/productosProveedores',compact('productos','proveedores'));
    }
    public function guardarProductoProveedor(Request $request)
    {
        $proveedor=Proveedor::find($request->input('proveedor'));
        
        if($proveedor){
            $proveedor->productos()->attach($proveedor->id,['producto_id' =>$request->input('producto'),'precio' =>$request->input('precio'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            Session::flash('message','Producto asociado correctamente');
            Session::flash('class','success');
        }
        else{
            Session::flash('message','Erroal asoociar el producto con el proveedor');
            Session::flash('class','danger');
        }
    return redirect('admin/productosProveedores');
    
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
