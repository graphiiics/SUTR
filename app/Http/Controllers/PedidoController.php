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
       
    	$productos= Producto::orderBy('nombre', 'asc')->get();
        $unidades=Unidad::orderBy('id', 'asc')->get();
    	return view('pedidos/index',compact('productos','unidades'));
    }
     public function obtenerPedidos()
    {
        switch (Auth::user()->tipo) {
            case 1:
               $pedidos = Pedido::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'desc')->paginate(10);;
                break;
            case 2:
               $pedidos = Pedido::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'desc')->paginate(10);;
                break;
            case 3:
                $pedidos = Pedido::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->where('user_id',Auth::user()->id)->orderBy('id', 'desc')->paginate(10);;
                break;
        }
        foreach ($pedidos as $pedido) {
            
            foreach ($pedido->productos as $key=>$producto) {
               $producto->editando=false;
               $producto->stock=$this->cantidadAlmacen($producto);
            }
            $pedido->user;
            $pedido->unidad;
            if($pedido->estatus==1)
                $pedido->estatus='Pendiente';
            elseif($pedido->estatus==2)
                $pedido->estatus='Realizado';
            elseif($pedido->estatus==3)
                $pedido->estatus='Entregado';
        }
        $response = [
            'pagination' => [
                'total' => $pedidos->total(),
                'per_page' => $pedidos->perPage(),
                'current_page' => $pedidos->currentPage(),
                'last_page' => $pedidos->lastPage(),
                'from' => $pedidos->firstItem(),
                'to' => $pedidos->lastItem()
            ],
            'data' => $pedidos
        ];
    
        return $response;
    }

    public function productosPedidos()
    {
        $productos= Producto::orderBy('nombre', 'asc')->get();
        foreach ($productos as $key=>$producto) {
            $cantidad=$this->cantidadAlmacen($producto);
            if($cantidad<1){
                unset($productos[$key]);
            }else{
                $producto->key=$key;
                $producto->stock=$cantidad;
            }
        }
        return $productos;
    }
    public function productosNoPedido(Pedido $pedido){
        $productos= $this->productosPedidos();

        foreach($pedido->productos as $producto) {
            $pivot=$producto->pivot;
            foreach ($productos as $key=> $prod) {
                $prod->editando=false;
                $prod->pivot=$pivot;
                if($producto->id==$prod->id){
                     unset($productos[$key]);
                }
            }
        }
        return $productos;
    }
    public function cantidadAlmacen(Producto $producto)
    {
        return $producto->unidades()->first()->pivot->cantidad;
    }
    public function guardarPedido(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$pedido= new Pedido;
	    	$pedido->user_id=Auth::user()->id;
	    	$pedido->unidad_id=Auth::user()->unidad_id;
	    	$pedido->fecha=date('Y-m-d H:i:s');
	    	$pedido->estatus=1;
            $pedido->observaciones=$request->input('observaciones');
    		if($pedido->save()){
	    		for ($i=1; $i <=intval($request->input('totalProductos')); $i++) { 
                    $producto=Producto::find($request->input('producto'.$i));
                    $cantidadActual=$producto->unidades()->find(1)->pivot->cantidad;
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
    				return "eliminada";
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
    			return "eliminada";
    		}else{
    			Session::flash('message','Error al eliminar el pedido');
            	Session::flash('class','danger');
    		}
    	}
    	
    	
    }
    public function recibirPedido( Pedido $pedido){
        $productos=$pedido->productos;
        $registro= new Registro;
        $registro->user_id=Auth::user()->id;
        $registro->unidad_id=Auth::user()->unidad_id;
        $registro->fecha=date('Y-m-d H:i:s');
        $registro->tipo=1;
        $registro->observaciones='Entrada de pedido desde el almacén';
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
               
                Session::flash('message','Pedido recibido correctamente');
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
    public function actualizarPedido(Pedido $pedido,Request $request)
    {
       // return $request->all();
       if($request->input('observaciones')!=null){
            $pedido->observaciones=$pedido->comentarios."\n".Auth::user()->name.": ".$request->input('observaciones');   
        }
        $pedido->productos()->detach();
        for($i=0;$i<intval($request->input('totalProductos'));$i++){ 
            $producto=Producto::find($request->input('productoEditar'.$i));
            $cantidadActual=$producto->unidades()->find(1)->pivot->cantidad;
            $cantidadSolicitada=$request->input('cantidadEditar'.$i);
            $cantidadFinal=$cantidadActual-$cantidadSolicitada;
            if($cantidadSolicitada>$cantidadActual){
                $cantidadSolicitada=$cantidadActual;                       
            }
            $pedido->productos()->attach($pedido->id,['producto_id'=>$request->input('productoEditar'.$i),'cantidad'=>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]); 
        }
        if($pedido->save()){
           
            Session::flash('message','Pedido actulizado correctamente');
            Session::flash('class','success');
        }
        else{
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
    public function emitirPedido( Pedido $pedido, Request $request){
           
            if($request->input('observaciones')!=null){
                $pedido->observaciones=$pedido->comentarios."\n".Auth::user()->name.": ".$request->input('observaciones');
                $pedido->save();
            }
            
            $registro= new Registro;
            $registro->user_id=Auth::user()->id;
            $registro->unidad_id=Auth::user()->unidad_id;
            $registro->fecha=date('Y-m-d H:i:s');
            $registro->tipo=2;
            $registro->observaciones='Salida de pedido hacia la unidad '.$pedido->unidad->nombre;
            if($registro->save()){
                $pedido->productos()->detach();
                for($i=0;$i<intval($request->input('totalProductos'));$i++){ 
                    $producto=Producto::find($request->input('productoEditar'.$i));
                    $cantidadActual=$producto->unidades()->find(1)->pivot->cantidad;
                    $cantidadSolicitada=$request->input('cantidadEditar'.$i);
                    $cantidadFinal=$cantidadActual-$cantidadSolicitada;
                    if($cantidadSolicitada>$cantidadActual){
                        $cantidadSolicitada=$cantidadActual;                       
                    }
                    $pedido->productos()->attach($pedido->id,['producto_id'=>$request->input('productoEditar'.$i),'cantidad'=>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                    $registro->productos()->attach($registro->id,['producto_id' =>$request->input('productoEditar'.$i),'cantidad' =>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
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
              if($pUnidad->unidad_id==Auth::user()->unidad_id){
                if($producto->stocks()->find(Auth::user()->unidad_id)->pivot->cantidad>$pUnidad->pivot->cantidad){
                    $notificacion= new Notificacion;
                    $notificacion->user_id=Auth::user()->id;
                    $notificacion->emisor='Sistema de control de inventarios';
                    $notificacion->mensaje ="El productos ".$producto->nombre." ya esta por debajo del limite indispensable  para la unidad: ".Auth::user()->unidad->nombre;
                    $notificacion->tipo="Productos";
                    $notificacion->link="productos";
                    $notificacion->estado=2;
                    $notificacion->save();
                }
              }
            }
        $producto->update(['stock'=>$stock]);
    }
    
}
