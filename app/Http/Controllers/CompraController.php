<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Compra;
use App\Proveedor;
use App\Producto;
use Auth;
use Session;
use App\Http\ProdutoController;


class CompraController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$compras = Compra::orderBy('id', 'asc')->get();
        $proveedores = Proveedor::orderBy('id', 'asc')->get();
    	return view('compras/index',compact('compras','proveedores'));
    }
    
    public function guardarCompra(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$compra= new Compra;
	    	$compra->user_id=Auth::user()->id;
	    	$compra->fecha=date('Y-m-d H:i:s');
            $compra->importe=$request->input('importe');
	    	$compra->proveedor_id=$request->input('proveedor');
            $proveedor=Proveedor::find($request->input('proveedor'));

    		if($compra->save()){
	    		for ($i=1; $i <=intval($request->input('totalProductos')); $i++) { 
                        $producto=Producto::find($request->input('producto'.$i));
                        $cantidadActual=$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad;
                        $cantidadSolicitada=$request->input('cantidad'.$i);
	    			    $compra->productos()->attach($compra->id,['producto_id' =>$producto->id,'cantidad' =>$request->input('cantidad'.($i)),'precio'=>$request->input('precio'.($i)),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                        $proveedor->productos()->updateExistingPivot($producto->id,['precio' =>$request->input('precio'.($i)),'updated_at'=>date('Y-m-d H:i:s')]);
                        $cantidadFinal=$cantidadActual+$cantidadSolicitada;
                         $producto->unidades()->updateExistingPivot(Auth::user()->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')]); 
                         $producto->update(['precio'=>$request->input('precio'.$i)]);

	    		}
                $productoController=ProdutoController::Class;
                $productoController->actualizarStock();
	    		Session::flash('message','Compra registrada correctamente');
		        Session::flash('class','success');
	    	}else{
	    		Session::flash('message','Error al registra compra');
		        Session::flash('class','danger');
	    	}
    	}else{
    		session::flash('message','La compra no contiene ningún producto');
		    Session::flash('class','danger');
    	}
    	
    	return redirect('admin/compras');
    	 // return $request->all();
    }

    public function obtenerProveedor(Proveedor $proveedor)
    {
        return $proveedor->productos;
    }
}
