<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Corte;
use App\Venta;
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
               $cortes = Corte::orderBy('id', 'asc')->get();
                break;
            case '2':
                $cortes = Corte::orderBy('id', 'asc')->get();
                break;
            case '3':
               $cortes = Corte::where('user_id',Auth::user()->id)->orderBy('id', 'asc')->get();
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
	    			$venta->update(['corte'=>true,'fecha_corte'=>date('y-m-d H:i')]);
	    			$importe+=$venta->importe;
	    			if(strtotime($fecha)>strtotime($venta->fecha)){
	    				$fecha=$venta->fecha;
	    			}
	    			$venta->cortes()->attach($corte->id,['created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                    
	    		}
	    	}	
	    	$corte->update(['importe'=>$importe,'fecha_inicio'=>$fecha]);
	    	Session::flash('message','Corte realidado correctamente del día '.$fecha);
		    Session::flash('class','success');
    	}
    	else{
    		Session::flash('message','No hay ventas disponibles para realizar el corte de caja');
		    Session::flash('class','danger');
    	}
    	return redirect('gerente\ventas');
    }


}
