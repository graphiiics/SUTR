<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Venta;
use App\Producto;
use Auth;
use Session;


class VentaController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$ventas = Venta::orderBy('id', 'asc')->get();
    	$productos = Producto::where('categoria','suplemento')->orderBy('id', 'asc')->get();
    	return view('ventas/index',compact('ventas','productos'));
    }

    public function guardarVenta(Request $request){
    	
    	if($request->input('totalProductos')>0){
    		$venta= new Venta;
	    	$venta->user_id=Auth::user()->id;
	    	$venta->fecha=date('Y-m-d H:i:s');
	    	$venta->cliente=$request->input('cliente');
	    	$venta->estatus=$request->input('estatus');
	    	$venta->importe=$request->input('importe');
    		if($venta->save()){
	    		for ($i=0; $i <intval($request->input('totalProductos')); $i++) { 
	    			    $venta->productos()->attach($venta->id,['producto_id' =>$request->input('producto'.($i+1)),'cantidad' =>$request->input('cantidad'.($i+1)),'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
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
    	
    	return redirect('admin/ventas');
    	 // return $request->all();
    }
}
