<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Registro;
use App\Producto;
use App\Unidad;
use App\User;
use App\notificacion;
use Session;
use Auth;


class RegistroController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        
    	return view('registros/index');
    }
    public function obtenerRegistros(){
         switch (Auth::user()->tipo) {
            case 1:
                $registros = Registro::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'des')->paginate(10);
                break;
            case 2:
               $registros = Registro::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'des')->paginate(10);
                break;
            case 3:
               $registros = Registro::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->where('user_id',Auth::user()->id)->orderBy('id', 'des')->paginate(10);;
                break;
        }
        foreach ($registros as $registro) {

            $registro->user;
            $registro->unidad;
            $registro->productos;
            if($registro->tipo==1)
                $registro->tipo="Entrada";
            elseif($registro->tipo==2)
                $registro->tipo="Salida";
            
        }
        $response = [
            'pagination' => [
                'total' => $registros->total(),
                'per_page' => $registros->perPage(),
                'current_page' => $registros->currentPage(),
                'last_page' => $registros->lastPage(),
                'from' => $registros->firstItem(),
                'to' => $registros->lastItem()
            ],
            'data' => $registros
        ];
    
        return $response;
    }
    public function productosSalida()
    {
        $productos= Producto::orderBy('nombre', 'asc')->get();
        foreach ($productos as $key=>$producto) {
            $cantidad=$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad;
            if($cantidad<1){
                unset($productos[$key]);
            }else{
                $producto->key=$key;
                $producto->stock=$cantidad;
            }
        }
        return $productos;
    }
    public function productosEntrada(Producto $producto)
    {
        $productos= Producto::orderBy('nombre', 'asc')->get();
        foreach ($productos as $key=>$producto) {
            
                $producto->key=$key;
                $producto->stock=100;
            
        }
        return $productos;
    }
    public function obtenerRegistroBusqueda()
    {
         switch (Auth::user()->tipo) {
            case 1:
                $registros = Registro::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'des')->get();
                break;
            case 2:
               $registros = Registro::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'des')->get();
                break;
            case 3:
               $registros = Registro::where('fecha','>=',date("Y-m-d", strtotime("-2 month")))->where('user_id',Auth::user()->id)->orderBy('id', 'des')->get();;
                break;
        }
        foreach ($registros as $registro) {

            $registro->user;
            $registro->unidad;
            $registro->productos;
            if($registro->tipo==1)
                $registro->tipo="Entrada";
            elseif($registro->tipo==2)
                $registro->tipo="Salida";
            
        }
   
    return $registros;
    }

    public function guardarRegistro(Request $request){
    	 
    	if($request->input('totalProductos')>0){
    		$registro= new Registro;
	    	$registro->user_id=Auth::user()->id;
	    	$registro->unidad_id=$request->input('unidad');
	    	$registro->fecha=date('Y-m-d H:i:s');
	    	$registro->tipo=$request->input('tipo');
            $registro->observaciones=$request->input('observaciones');
    		if($registro->save()){
	    		for ($i=1; $i <=intval($request->input('totalProductos')); $i++) { 
	    			    $producto=Producto::find($request->input('producto'.$i));
                        $cantidadActual=$producto->unidades()->find($registro->unidad_id)->pivot->cantidad;
                        $cantidadSolicitada=$request->input('cantidad'.$i);

                        if($registro->tipo==1){//Entrada
                            $cantidadFinal=$cantidadSolicitada+$cantidadActual;
                            if($producto->unidades()->updateExistingPivot($registro->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')])){
                            Session::flash('message','Registro realizado correctamente');
                            Session::flash('class','success');
                            $this->actualizarStock($producto->id);
                            }else{
                                $registro->delete();
                                Session::flash('message','Error al crear el registro');
                                Session::flash('class','danger');
                            } 
                           
                        }
                        elseif ($registro->tipo==2) {//Salida
                            
                            if($cantidadSolicitada>$cantidadActual){
                                $cantidadFinal=0;
                                $cantidadSolicitada=$cantidadActual;
                                foreach (User::where('tipo',1)->orWhere('tipo',2)->get() as $user) {
                                        $notificacion= new Notificacion;
                                        $notificacion->user_id=$user->id;
                                        $notificacion->emisor="Sistema de control de productos";
                                        $notificacion->mensaje ="El producto: ".$producto->nombre." en la unidad: ".$registro->unidad->nombre." ya no cuenta con ninguna pieza, se recomienda surtir lo antes posible.";
                                        $notificacion->tipo="Productos";
                                        $notificacion->link="productos";
                                        $notificacion->estado=2;
                                        $notificacion->save();
                                }
                                if(Auth::user()->tipo==3){
                                    $notificacion= new Notificacion;
                                    $notificacion->user_id=Auth::user()->id;
                                    $notificacion->emisor="Sistema de control de productos";
                                    $notificacion->mensaje ="El producto: ".$producto->nombre." en la unidad: ".$registro->unidad->nombre." ya no cuenta con ninguna pieza, se recomienda realizar un pedido lo antes posible.";
                                    $notificacion->tipo="Productos";
                                    $notificacion->link="productos";
                                    $notificacion->estado=2;
                                    $notificacion->save();
                                }
                            }else{
                                $cantidadFinal=$cantidadActual-$cantidadSolicitada;
                                if($cantidadFinal<$producto->unidades()->find(Auth::user()->unidad_id)->pivot->stock_minimo){
                                    foreach (User::where('tipo',1)->orWhere('tipo',2)->get() as $user) {
                                        $notificacion= new Notificacion;
                                        $notificacion->user_id=$user->id;
                                        $notificacion->emisor="Sistema de control de productos";
                                        $notificacion->mensaje ="El stock del producto: ".$producto->nombre." en la unidad: ".$registro->unidad->nombre." esta por debajo del limite, se recomienda surtir lo antes posible.";
                                        $notificacion->tipo="Productos";
                                        $notificacion->link="productos";
                                        $notificacion->estado=2;
                                        $notificacion->save();
                                    }
                                    $notificacion= new Notificacion;
                                        $notificacion->user_id=Auth::user()->id;
                                        $notificacion->emisor="Sistema de control de productos";
                                        $notificacion->mensaje ="El stock del producto: ".$producto->nombre." en la unidad: ".$registro->unidad->nombre." esta por debajo del limite, se recomienda surtir lo antes posible.";
                                        $notificacion->tipo="Productos";
                                        $notificacion->link="productos";
                                        $notificacion->estado=2;
                                        $notificacion->save();
                                }
                            }
                            if($producto->unidades()->updateExistingPivot($registro->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')])){
                            Session::flash('message','Registro realizado correctamente');
                            Session::flash('class','success');
                            $this->actualizarStock($producto->id);
                            }else{
                                $registro->delete();
                                Session::flash('message','Error al crear el registro');
                                Session::flash('class','danger');
                            } 

                        }//termina salida
                        $registro->productos()->attach($registro->id,['producto_id' =>$producto->id,'cantidad' =>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                            $this->actualizarStock($producto->id);
                        
                       
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
    	
    	switch (Auth::user()->tipo) {
        case 1:
               return redirect('superAdmin/registros');
            break;
         case 2:
               return redirect('admin/registros');
            break;
        case 3:
                return redirect('gerente/registros');
            break;
       }
    	// return $request->all();
    }
    
    public function eliminarRegistro( Registro $registro){
    	if(count($registro->productos)>0){
    		if($registro->productos()->detach()){
    			if($registro->delete()){
    				Session::flash('message','Registro eliminado correctamente');
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
     public function actualizarStock($id){
        $producto=Producto::find($id);
       
          $stock=0;
            foreach ($producto->unidades as $pUnidad) {
              $stock=$stock+$pUnidad->pivot->cantidad;
            }
          $producto->update(['stock'=>$stock]);
    }
}

