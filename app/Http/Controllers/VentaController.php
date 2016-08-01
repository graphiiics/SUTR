<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Venta;
use App\Producto;
use App\User;
use App\Notificacion;
use Auth;
use Session;

 
class VentaController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        switch (Auth::user()->tipo) {
            case 1:
                $ventas = Venta::orderBy('id', 'asc')->get();
                break;
            case 2:
                $ventas = Venta::orderBy('id', 'asc')->get();
                break;
            case 3:
                $ventas = Venta::where('user_id',Auth::user()->id)->orderBy('id', 'asc')->get();
                break;
        }
    	
    	$productos = Producto::where('categoria','suplemento')->orderBy('id', 'asc')->get();
       
        return view('ventas/index',compact('ventas','productos'));
       
    }

    public function guardarVenta(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$venta= new Venta;
	    	$venta->user_id=Auth::user()->id;
	    	$venta->fecha=date('Y-m-d H:i:s');
	    	$venta->cliente=$request->input('cliente');
	    	$venta->pago=$request->input('pago');
	    	$venta->importe=$request->input('importe');
            if($request->input('instalador')){
                $venta->comentarios='Instaló: '.$request->input('instalador');
            }
            if($venta->pago==1){
                $venta->estatus=1;
            }
            else{
                $venta->estatus=2;
                 foreach (User::where('tipo',1)->orWhere('tipo',2)->get() as $user) {
                    $notificacion= new Notificacion;
                    $notificacion->user_id=$user->id;
                    $notificacion->emisor=Auth::user()->name;
                    $notificacion->mensaje ="Realizé una venta a credito, al cliente: ".$venta->cliente.", por un monto total de $".$venta->importe.".00";
                    $notificacion->tipo="Ventas";
                    $notificacion->link="ventas";
                    $notificacion->estado=2;
                    $notificacion->save();
                }
            }
    		if($venta->save()){
	    		for ($i=1; $i <=intval($request->input('totalProductos')); $i++) { 
                    $producto=Producto::find($request->input('producto'.($i)));
                    $cantidadActual=$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad;
                    $cantidadSolicitada=$request->input('cantidad'.$i);
    			    if($cantidadActual>=$cantidadSolicitada){
                        $cantidadFinal=$cantidadActual-$cantidadSolicitada;
                        $producto->unidades()->updateExistingPivot(Auth::user()->unidad_id,['cantidad' =>$cantidadFinal,'updated_at'=>date('Y-m-d H:i:s')]);
                        $venta->productos()->attach($venta->id,['producto_id' =>$producto->id,'cantidad' =>$cantidadSolicitada,'precio'=>$request->input('precio'.$i),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                    }
                    else{
                        $venta->delete();
                        Session::flash('message','El producto no cuenta con esa cantidad disponible');
                        Session::flash('class','danger');
                        break;
                    }
                    $this->actualizarStock($producto->id);
	    		}
	    		Session::flash('message','Venta realizada correctamente');
		        Session::flash('class','success');
	    	}else{
	    		Session::flash('message','Error al crear la venta');
		        Session::flash('class','danger');
	    	}
        	}else{
        		session::flash('message','La venta no contiene ningún producto');
    		    Session::flash('class','danger');
        	}
    	
    
    	 // return $request->all();
        switch (Auth::user()->tipo) {
            case 1:
                return redirect('superAdmin/ventas');
                break;
            case 2:
                return redirect('admin/ventas');
                break;
            case 3:
                return redirect('gerente/ventas');
                break;
        }
       
    }

    public function liquidarVenta(Venta $venta)
    {
        if($venta->update(['estatus'=>1])){
            Session::flash('message','Venta liquidada correctamente');
            Session::flash('class','success');
            foreach (User::where('tipo',1)->orWhere('tipo',2)->get() as $user) {
                    $notificacion= new Notificacion;
                    $notificacion->user_id=$user->id;
                    $notificacion->emisor=Auth::user()->name;
                    $notificacion->mensaje ="Liquidé la venta a credito con id: ".$venta->id.", del cliente: ".$venta->cliente.", por un monto total de $".$venta->importe.".00";
                    $notificacion->tipo="Ventas";
                    $notificacion->link="ventas";
                    $notificacion->estado=2;
                    $notificacion->save();
                }
        }else{
            Session::flash('message','Error al liquidar la venta');
            Session::flash('class','danger');
        }

         switch (Auth::user()->tipo) {
            case 1:
                return redirect('superAdmin/ventas');
                break;
            case 2:
                return redirect('admin/ventas');
                break;
            case 3:
                return redirect('gerente/ventas');
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
