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
        switch (Auth::user()->tipo) {
            case '1':
               $registros = Registro::orderBy('id', 'asc')->get();
                break;
            case '2':
                $registros = Registro::orderBy('id', 'asc')->get();
                break;
            case '3':
               $registros = Registro::where('user_id',Auth::user()->id)->orderBy('id', 'asc')->get();
                break;
        }
    	
    	$productos = Producto::orderBy('id', 'asc')->get();
        $unidades= Unidad::orderBy('id', 'asc')->get();
    	return view('registros/index',compact('registros','productos','unidades'));
    }

    public function guardarRegistro(Request $request){
    	 
    	if($request->input('totalProductos')>0){
    		$registro= new Registro;
	    	$registro->user_id=Auth::user()->id;
	    	$registro->unidad_id=$request->input('unidad');
	    	$registro->fecha=date('Y-m-d H:i:s');
	    	$registro->tipo=$request->input('tipo');
    		if($registro->save()){
	    		for ($i=1; $i <=intval($request->input('totalProductos')); $i++) { 
	    			    $producto=Producto::find($request->input('producto'.$i));
                        $cantidadActual=$producto->unidades()->find($registro->unidad_id)->pivot->cantidad;
                        $cantidadSolicitada=$request->input('cantidad'.$i);

                        if($registro->tipo==1){//Entrada
                            $cantidadFinal=$cantidadSolicitada+$cantidadActual;
                            $producto->unidades()->updateExistingPivot($registro->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')]); 
                           
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
                                if($cantidadFinal<$producto->stock){
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
                                }
                            }
                             $producto->unidades()->updateExistingPivot($registro->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')]);

                        }//termina salida
                         $registro->productos()->attach($registro->id,['producto_id' =>$producto->id,'cantidad' =>$cantidadSolicitada,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
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
    				Session::flash('message','Pedido eliminado correctamente');
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
}
