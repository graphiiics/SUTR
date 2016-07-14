<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pedido;
use App\Producto;
use Auth;
use Session;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$pedidos = Pedido::orderBy('id', 'desc')->get();
    	$productos= Producto::orderBy('id', 'asc')->get();
    	return view('pedidos/index',compact('pedidos','productos'));
    }

    public function guardarPedido(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$pedido= new Pedido;
	    	$pedido->user_id=Auth::user()->id;
	    	$pedido->unidad_id=$request->input('unidad');
	    	$pedido->fecha=date('Y-m-d H:i:s');
	    	$pedido->estatus=1;
    		if($pedido->save()){
	    		for ($i=0; $i <intval($request->input('totalProductos')); $i++) { 
	    			    $pedido->productos()->attach($pedido->id,['producto_id' =>$request->input('producto'.($i+1)),'cantidad' =>$request->input('cantidad'.($i+1)),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
	    		}
	    		Session::flash('message','Pedido realizado correctamente');
		        Session::flash('class','success');
	    	}else{
	    		Session::flash('message','Error al crear el pedido');
		        Session::flash('class','danger');
	    	}
    	}else{
    		session::flash('message','El pedido no contiene ningún producto');
		    Session::flash('class','danger');
    	}
    	
    	return redirect('admin/pedidos');
    }

    public function eliminarPedido( Pedido $pedido){
    	if(count($pedido->productos)>0){
    		if($pedido->productos()->detach()){
    			if($pedido->delete()){
    				Session::flash('message','Pedido eliminado correctamente');
	            	Session::flash('class','success');
	    		}else{
	    			Session::flash('message','Error al eliminar el pedido');
	            	Session::flash('class','danger');
    		}
	    	}
	    	else{
	    		Session::flash('message','Error al eliminar los productos del pedido');
	            Session::flash('class','danger');
	    	}
    	}
    	else{
    		if($pedido->delete()){
    			Session::flash('message','Pedido eliminado correctamente');
            	Session::flash('class','success');
    		}else{
    			Session::flash('message','Error al eliminar el pedido');
            	Session::flash('class','danger');
    		}
    	}
    	
    	return redirect('admin/pedidos');
    }
}
