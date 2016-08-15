<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Proveedor;
use App\Producto;
use App\Compra;
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
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('proveedores/productosProveedores',compact('productos','proveedores'));
    }
    public function guardarProductoProveedor(Request $request)
    {   
        $noRepetido=true;
        $proveedor=Proveedor::find($request->input('proveedor'));
        
        foreach ($proveedor->productos as $producto) {
            if($producto->pivot->producto_id==$request->input('producto')){
                $noRepetido=false;
                break;
            }
        }
        if($proveedor && $noRepetido){
            $proveedor->productos()->attach($proveedor->id,['producto_id' =>$request->input('producto'),'precio' =>$request->input('precio'),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            Session::flash('message','Producto asociado correctamente');
            Session::flash('class','success');
        }
        else{
            Session::flash('message','Erro al asoociar el producto con el proveedor');
            Session::flash('class','danger');
        }
    return redirect('admin/productosProveedores');
    
    }
    public function editarProductoProveedor(Request $request)
    {   
        $noRepetido=true;
        $proveedor=Proveedor::find($request->input('proveedor'));
        if($request->input('eliminar')){
           if($proveedor ){
                $proveedor->productos()->detach($request->input('productoActual'));
                Session::flash('message','Relación eliminada correctamente');
                Session::flash('class','success');
            }
            else{
                Session::flash('message','Error al eliminar la relación');
                Session::flash('class','danger');
            }
        }
        else{
             foreach ($proveedor->productos as $producto) {
                if($producto->pivot->producto_id==$request->input('producto') && $producto->pivot->producto_id!=$request->input('productoActual')){
                    $noRepetido=false;
                    break;
                }
            }
            if($proveedor && $noRepetido){
                $proveedor->productos()->updateExistingPivot($request->input('productoActual'),['producto_id' =>$request->input('producto'),'precio' =>$request->input('precio'),'updated_at'=>date('Y-m-d H:i:s')]);
                Session::flash('message','Producto asociado correctamente');
                Session::flash('class','success');
            }
            else{
                Session::flash('message','Error al asoociar el producto con el proveedor');
                Session::flash('class','danger');
            }
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
                foreach (Compra::where('proveedor_id',$proveedor->id)->get() as $compra) {
                    $compra->productos()->detach();
                    $compra->delete();
                }
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

    public function productosDisponibles(Proveedor $proveedor)
    {
        $productos = Producto::all();
        foreach ($proveedor->productos as $producto) {
            foreach ($productos as $key=>$prod) {
                if($prod->id==$producto->pivot->producto_id){
                    $productos->pull($key);
                    break;
                }
            }
        }
        return $productos;
    }
}
