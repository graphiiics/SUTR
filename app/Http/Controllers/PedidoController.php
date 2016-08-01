<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pedido;
use App\Producto;
use Auth;
use Session;
use App\Registro;
use App\Notificacion;
use App\User;
use App\Unidad;
class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        switch (Auth::user()->tipo) {
            case 1:
               $pedidos = Pedido::orderBy('id', 'desc')->get();
                break;
            case 2:
               $pedidos = Pedido::orderBy('id', 'desc')->get();
                break;
            case 3:
                $pedidos = Pedido::where('user_id',Auth::user()->id)->get();
                break;
        }
    	$productos= Producto::orderBy('id', 'asc')->get();
        $unidades=Unidad::orderBy('id', 'asc')->get();
    	return view('pedidos/index',compact('pedidos','productos','unidades'));
    }

    public function guardarPedido(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$pedido= new Pedido;
	    	$pedido->user_id=Auth::user()->id;
	    	$pedido->unidad_id=$request->input('unidad');
	    	$pedido->fecha=date('Y-m-d H:i:s');
	    	$pedido->estatus=1;
    		if($pedido->save()){
	    		for ($i=1; $i <=intval($request->input('totalProductos')); $i++) { 

                        $producto=Producto::find($request->input('producto'.$i));
                        $cantidadActual=$producto->unidades()->find(5)->pivot->cantidad;
                        $cantidadSolicitada=$request->input('cantidad'.$i);
                        if($cantidadActual<$cantidadSolicitada){
                            $cantidadSolicitada=$cantidadActual;
                        }
	    			    $pedido->productos()->attach($pedido->id,['producto_id' =>$producto->id,'cantidad' =>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
	    		}
                foreach (User::where('tipo',1)->orWhere('tipo',2)->get() as $user) {
                    $notificacion= new Notificacion;
                    $notificacion->user_id=$user->id;
                    $notificacion->emisor=Auth::user()->name;
                    $notificacion->mensaje ="Acabo de realizar un nuevo pedido con id:".$pedido->id.", espero su pronta llegada.";
                    $notificacion->tipo="Pedidos";
                    $notificacion->link="pedidos";
                    $notificacion->estado=2;
                    $notificacion->save();
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
    	
        switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/pedidos');
            break;
         case 2:
               return redirect('admin/pedidos');
            break;
        case 3:
                return redirect('gerente/pedidos');
            break;
       }
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
    	
    	switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/pedidos');
            break;
         case 2:
               return redirect('admin/pedidos');
            break;
        case 3:
                return redirect('gerente/pedidos');
            break;
           
       }
    }
    public function recibirPedido( Pedido $pedido){
        $productos=$pedido->productos;
        $registro= new Registro;
        $registro->user_id=Auth::user()->id;
        $registro->unidad_id=Auth::user()->unidad_id;
        $registro->fecha=date('Y-m-d H:i:s');
        $registro->tipo=1;
        if($registro->save()){
           foreach ($productos as $producto) {
                $cantidadActual=$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad;
                $cantidadSolicitada=$producto->pivot->cantidad;
                $cantidadFinal=$cantidadActual+$cantidadSolicitada;
                $producto->unidades()->updateExistingPivot(Auth::user()->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')]);
                $registro->productos()->attach($registro->id,['producto_id' =>$producto->id,'cantidad' =>$producto->pivot->cantidad,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                 $this->actualizarStock($producto->id);
            }
            $pedido->estatus=3;
            if($pedido->save()){
               
                Session::flash('message','Pedido emitido correctamente');
                Session::flash('class','success');
            }
          
        }else{
            Session::flash('message','Error al emitir pedido');
            Session::flash('class','danger');
        }
        switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/pedidos');
            break;
         case 2:
               return redirect('admin/pedidos');
            break;
        case 3:
                return redirect('gerente/pedidos');
            break;
           
       }
    }
    public function agregarComentario(Pedido $pedido,Request $request)
    {
       if($request->input('comentarios')!=null){
                $pedido->comentarios=$pedido->comentarios."\n".Auth::user()->name.": ".$request->input('comentarios');
                $pedido->save();
            }
    }
    public function emitirPedido( Pedido $pedido, Request $request){
            $productos=$pedido->productos;
            for ($i=0; $i <count($productos) ; $i++) { 
                $pedido->productos()->updateExistingPivot($request->input('productoEditar'.$i),['cantidad'=>$request->input('cantidadEditar'.$i),'updated_at'=>date('Y-m-d H:i:s')]); 
            }
            if($request->input('comentarios')!=null){
                $pedido->comentarios=$pedido->comentarios."\n".Auth::user()->name.": ".$request->input('comentarios');
                $pedido->save();
            }
      
            $registro= new Registro;
            $registro->user_id=Auth::user()->id;
            $registro->unidad_id=Auth::user()->unidad_id;
            $registro->fecha=date('Y-m-d H:i:s');
            $registro->tipo=2;
            if($registro->save()){
               foreach ($productos as $producto) {
                    $cantidadActual=$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad;
                    $cantidadSolicitada=$producto->pivot->cantidad;
                    $cantidadFinal=$cantidadActual-$cantidadSolicitada;
                    if($cantidadSolicitada>$cantidadActual){
                        $cantidadFinal=$cantidadActual;
                    }
                    $registro->productos()->attach($registro->id,['producto_id' =>$producto->id,'cantidad' =>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                    $producto->unidades()->updateExistingPivot(Auth::user()->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')]);
                     $this->actualizarStock($producto->id);
                }
                $pedido->estatus=2;
                if($pedido->save()){
                    $notificacion= new Notificacion;
                    $notificacion->user_id=$pedido->user->id;
                    $notificacion->emisor=Auth::user()->name;
                    $notificacion->mensaje ="Se ha surtido tu pedido con id=".$pedido->id." y  está a punto de salir en dirección a la unidad";
                    $notificacion->tipo="Pedidos";
                    $notificacion->link="pedidos";
                    $notificacion->estado=2;
                    $notificacion->save();
                    Session::flash('message','Pedido emitido correctamente');
                    Session::flash('class','success');
                }
              

            }else{
                Session::flash('message','Error al emitir pedido');
                Session::flash('class','danger');
            }
        switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/pedidos');
            break;
         case 2:
               return redirect('admin/pedidos');
            break;
        case 3:
                return redirect('gerente/pedidos');
            break;
       }
    }
    public function actualizarStock($id){
        $producto=Producto::find($id);
       
          $stock=0;
            foreach ($producto->unidades as $pUnidad) {
              $stock=$stock+$pUnidad->pivot->cantidad;
            }
          $producto->update(['stock'=>$stock]);
    }
    
}
