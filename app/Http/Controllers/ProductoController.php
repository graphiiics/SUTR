<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Producto;
use Session;
use App\Unidad;

class ProductoController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$productos = Producto::orderBy('id', 'asc')->get();
    	return view('productos/index',compact('productos'));
    }
    public function productosProveedores(){
    	$productos = Producto::orderBy('id', 'asc')->get();
    	return view('productos/productosProveedores',compact('productos'));
    }

    public function editarProducto(Request $request, Producto $producto){
       if($producto->update(['nombre'=>$request->input('nombre'),'precio'=>$request->input('precio'),'categoria'=>$request->input('categoria')])){
           
            foreach ($producto->unidades as $key=>$value) {
               $producto->unidades()->updateExistingPivot($key+1,['cantidad' =>$request->input('unidad'.($key+1)),'updated_at'=>date('Y-m-d H:i:s')]);
            }
            Session::flash('message','Datos actualizados correctamente');
            Session::flash('class','success');
       }else{
             Session::flash('message','Error al actualizar los datos');
             Session::flash('class','danger');
       }

        return redirect('admin/productos');
      
    }

    public function guardarProducto(Request $request){

        $producto= new Producto($request->all());
        $unidades=Unidad::all();
        
        
        if($producto->save()){   
            foreach ($unidades as $key=>$value) {
               $producto->unidades()->attach($key+1,['cantidad' =>$request->input('unidad'.($key+1)),'producto_id'=>$producto->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            }         
            Session::flash('message','Producto creado correctamente');
            Session::flash('class','success');
       }else{
             Session::flash('message','Error al crear nuevo producto');
             Session::flash('class','danger');
       }
        return redirect('admin/productos');
    }
}
