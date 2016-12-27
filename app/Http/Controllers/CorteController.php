<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Corte;
use App\Venta;
use App\Egreso;
use App\ingreso;
use App\Producto;
use Auth;
use Session;
class CorteController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        switch (Auth::user()->tipo) {
            case '1':
               $cortes = Corte::where('fecha_corte','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'asc')->get();
                break;
            case '2':
                $cortes = Corte::where('fecha_corte','>=',date("Y-m-d", strtotime("-2 month")))->orderBy('id', 'asc')->get();
                break;
            case '3':
               $cortes = Corte::where('fecha_corte','>=',date("Y-m-d", strtotime("-2 month")))->where('user_id',Auth::user()->id)->orderBy('id', 'asc')->get();
                break;
        }
       	return view('cortes/index',compact('cortes'));
    }

    public function realizarCorte()
    {
    	$fecha=date('y-m-d H:i');
    	$importe=0;
    	$ventas=Venta::where(['corte'=>false,'estatus'=>1,'user_id'=>Auth::user()->id])->get();
    	if(count($ventas)){
    		$corte= new Corte;
	    	$corte->user_id=Auth::user()->id;
	    	$corte->unidad_id=Auth::user()->unidad_id;
	    	$corte->fecha_corte=date('y-m-d H:i:s');
	    	if($corte->save()){
	    		foreach ($ventas as $venta) {
	    			$venta->update(['corte'=>true,'fecha_corte'=>date('y-m-d')]);
	    			$importe+=$venta->importe;
	    			if(strtotime($fecha)>strtotime($venta->fecha)){
	    				$fecha=$venta->fecha;
	    			}
	    			$venta->cortes()->attach($corte->id,['created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                    
	    		}
	    	}	
	    	$corte->update(['importe'=>$importe,'fecha_inicio'=>$fecha]);
            $egresos = Egreso::where(['corte'=>false,'user_id'=>Auth::user()->id])->get();
            $ingresos =Ingreso::where(['corte'=>false,'user_id'=>Auth::user()->id])->get();
            foreach ($egresos as $egreso) {
                $egreso->update(['corte'=>true,'fecha_corte'=>date('y-m-d')]);
            }
            foreach ($ingresos as $ingreso) {
                $ingreso->update(['corte'=>true,'fecha_corte'=>date('y-m-d')]);
            }
            foreach (Producto::where('categoria','Suplemento')->get() as $producto) {
                
                 $producto->unidades()->updateExistingPivot(Auth::user()->unidad_id,['stock_corte'=>$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad,'updated_at'=>date('Y-m-d H:i:s')]);

            }
	    	Session::flash('message','Corte realidado correctamente del día '.$fecha);
		    Session::flash('class','success');
    	}
    	else{
            foreach (Producto::where('categoria','Suplemento')->get() as $producto) {
                
                 $producto->unidades()->updateExistingPivot(Auth::user()->unidad_id,['stock_corte'=>$producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad,'updated_at'=>date('Y-m-d H:i:s')]);

            }
    		Session::flash('message','No hay ventas disponibles para realizar el corte de caja');
		    Session::flash('class','danger');
    	}
    	return redirect('gerente\ventas');
    }
    public function obtenerIngresos()
    {
        return Ingreso::where('corte',0)->where('user_id',Auth::user()->id)->get();
    }
    public function obtenerEgresos()
    {
        return Egreso::where('corte',0)->where('user_id',Auth::user()->id)->get();
    }

    public function guardarIngresos(Request $request){
        $ingreso= new Ingreso();
        $ingreso->concepto=$request->input('concepto');
        $ingreso->importe=$request->input('importe');
        $ingreso->fecha=date('y-m-d');
        $ingreso->user_id=Auth::user()->id;
        $ingreso->corte=false;
        if($ingreso->save()){
            return 'exito';
        }
    }
    public function guardarEgresos(Request $request){
        $egreso= new Egreso();
        $egreso->concepto=$request->input('concepto');
        $egreso->importe=$request->input('importe');
        $egreso->fecha=date('y-m-d');
        $egreso->user_id=Auth::user()->id;
        $egreso->corte=false;
        if($egreso->save()){
            return 'exito';
        }
    }

    public function eliminarIngreso(Ingreso $ingreso){
        if($ingreso->delete()){
             return 'exito';
        }else{
            return 'error';
        }
    }
    public function eliminarEgreso(Egreso $egreso){
        if($egreso->delete()){
             return 'exito';
        }else{
            return 'error';
        }
    }


}
