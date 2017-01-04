<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Recibo;
use App\Unidad;
use App\Paciente;
use App\Beneficio;
use Auth;
use Session;
use App\Sesion;
use App\User;

class ReciboController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
         $d=strtotime("-3 Months");
        switch (Auth::user()->tipo) {
            case 1:
                $recibos = Recibo::where('fecha','>',date("Y-m-d", $d))->where('estatus','!=',6)->orderBy('fecha', 'asc')->get();
                break;
            case 2:
                $recibos = Recibo::where('fecha','>',date("Y-m-d", $d))->where('estatus','!=',6)->orderBy('fecha', 'asc')->get();

                break;
            case 3:
                $recibos = Recibo::where('fecha','>',date("Y-m-d", $d))->where('estatus','!=',6)->where('user_id',Auth::user()->id)->where('updated_at','>',date('Y-m-d'))->orWhere('estatus',1)->orWhere('estatus',3)->orderBy('fecha', 'asc')->get();
                
                break;
        }
        foreach ($recibos as $recibo) {
           $recibo->folios;
        }
        return $recibos;
    	$usuarios=User::where('tipo',3)->get();
        $pacientes=Paciente::where('unidad_id',Auth::user()->unidad_id)->where('estatus',1)->orderBy('nombre', 'asc')->get();
    	return view('recibos/index',compact('recibos','pacientes','usuarios'));
    }

    public function terminarRecibo(Recibo $recibo)
    {
        if($recibo->tipo_pago=="Credito"){
            if($recibo->update(['estatus'=>3])){
                Session::flash('message','¡Sesión terminada, No puedes imprimir el recibo hasta que se liquide la cuenta!');
                Session::flash('class','warning');
            }else{
               Session::flash('message','¡Error al terminar sesión!');
                Session::flash('class','danger');
            }
        }else{
            if($recibo->update(['estatus'=>2])){
                Session::flash('message','¡Sesión terminada, ahora puedes imprimir tu recibo!');
                Session::flash('class','success');
            }else{
                Session::flash('message','¡Error al terminar sesión!');
                Session::flash('class','danger');
            }
        }
    	
        return redirect('gerente/recibos');
    }

    public function liquidarRecibo(Recibo $recibo)
    {
       
        
            if($recibo->update(['estatus'=>2,'tipo_pago'=>'Hospital'])){
                Session::flash('message','Pago liquidado, ahora puedes imprimir tu recibo!');
                Session::flash('class','success');
            }else{
                Session::flash('message','¡Error al terminar sesión!');
                Session::flash('class','danger');
            }
    
        return redirect('gerente/recibos');
    }
    
    public function guardarRecibo(Request $request)
    {
    	$recibo= new Recibo($request->all());
    	$recibo->estatus=1; // 1:Emitido //2:Pagado 3:Credito 4:Conciliando 5:Finalizado
        $recibo->user_id=Auth::user()->id;
        $recibo->fecha=date('Y-m-d');
        if($request->input('beneficio_id')>0){
            $beneficio=Beneficio::find($request->input('beneficio_id'));
            $beneficio->sesiones_realizadas++;
            if($beneficio->sesiones_realizadas>=$beneficio->sesiones){
                $beneficio->estatus=2;
            }
            $beneficio->save();
        }
    	if($recibo->save()){
            $sesion = new Sesion;
            $sesion->recibo_id=$recibo->id;
            $sesion->fecha=date('Y-m-d');
            if ($sesion->save()) {
                Session::flash('message','Se iniciado la sesión correctamente, ya puedes imprimir la hoja de control');
                Session::flash('class','success');
            }
           
        }
        else{
            Session::flash('message','Error al iniciar Recibo, vuelve a intentarlo');
            Session::flash('class','danger');
        }
            
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/recibos'); //Cambiar a Sesiones
	    		break;
	    	case 2:
	    		return redirect('admin/recibos');
	    		break;
	    	case 3:
	    		return redirect('gerente/recibos');
	    		break;
    	
   		}
   	}
     public function cancelarRecibo(Recibo $recibo)
    {
        
             // 1:Emitido //2:Pagado 3:Credito 4:Conciliando 5:Finalizado 6:cancelado
        if($recibo->update(['estatus'=>6]))
        {
            if($recibo->beneficio && $recibo->tipo_pago.contains($recibo->beneficio->concepto->nombre)){
                $beneficio=Beneficio::find($recibo->beneficio_id);
                $beneficio->sesiones_realizadas--;
                $beneficio->save();

            }
                Session::flash('message','Recibo Cancelado correctamente');
                Session::flash('class','success');

        }
        else{
            Session::flash('message','Error al cancelar recibo, vuelve a intentarlo');
            Session::flash('class','danger');
        }
            
        switch (Auth::user()->tipo) {
            case 1:
                return redirect('superAdmin/recibos'); //Cambiar a Sesiones
                break;
            case 2:
                return redirect('admin/recibos');
                break;
            case 3:
                return redirect('gerente/recibos');
                break;
        
        }
    }
    public function datosPaciente(Paciente $paciente)
    {  
        $algo=array(); //array vacio
        $beneficio=Beneficio::where('estatus',1)->where('paciente_id',$paciente->id)->first();
        if(count($beneficio)){
            $beneficio->concepto;
            return $beneficio;
        }else{
           
            return $algo;
        }       
       
    }

 }