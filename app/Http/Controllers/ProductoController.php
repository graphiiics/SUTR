<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Producto;
use Session;
use Auth;
use App\Unidad;

class ProductoController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$productos = Producto::orderBy('id', 'asc')->get();
        $unidades=Unidad::all();
    	return view('productos/index',compact('productos','unidades'));
    }
    public function editarProducto(Request $request, Producto $producto){
       if($producto->update(['stock'=>$request->input('stock'),'nombre'=>$request->input('nombre'),'precio'=>$request->input('precio'),'categoria'=>$request->input('categoria')])){
           
            foreach ($producto->unidades as $key=>$value) {
               $producto->unidades()->updateExistingPivot($key+1,['cantidad' =>$request->input('unidad'.($key+1)),'updated_at'=>date('Y-m-d H:i:s')]); //checar funcion
            }
            Session::flash('message','Datos actualizados correctamente');
            Session::flash('class','success');
       }else{
             Session::flash('message','Error al actualizar los datos');
             Session::flash('class','danger');
       }
        $this->actualizarStock();
       switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/productos');
            break;
         case 2:
               return redirect('admin/productos');
            break;
        case 3:
                return redirect('gerente/productos');
            break;
           
       }
      
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
       $this->actualizarStock();
        switch (Auth::user()->tipo) {
       case 2:
               return redirect('admin/productos');
            break;
        case 2:
                return redirect('gerente/productos');
            break;
           
       }
    }
    public function cantidadAlmacen(Producto $producto)
    {
        return $producto->unidades()->find(5)->pivot->cantidad;
    }
    public function cantidadUnidad(Producto $producto)
    {
        return $producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad;
    }

    public function actualizarStock(){
        $productos=Producto::all();
        foreach ($productos as $producto) {
          $stock=0;
            foreach ($producto->unidades as $pUnidad) {
              $stock=$stock+$pUnidad->pivot->cantidad;
            }
          $producto->update(['stock'=>$stock]);
        }
    }
}
