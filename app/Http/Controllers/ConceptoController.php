<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Concepto;
use Session;

class ConceptoController extends Controller
{
    //
    public function consultar_conceptos(){

        $conceptos = Concepto::All();
        return view('super_views.consultar_conceptos',compact('conceptos'));
    }

    public function crear_concepto()
    {
        return view('super_views.crear_concepto');
    }

    public function guardar_concepto(Request $request)
    {
        $concepto = new Concepto;
        $concepto->nombre = $request->input('nombre');
        $concepto->estatus = 1;

        
        if($concepto->save()){
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
            
       return redirect('consultar_conceptos');
    }

    public function editar_concepto($id)
    {
        $concepto = Concepto::find($id);
        return view('super_views.editar_concepto',compact('concepto'));
              
    }

    public function actualizar_concepto(Request $request,$id)
    {
        $concepto = Concepto::find($id);
        $concepto->nombre = $request->input('nombre');

        if($concepto->save())
        {
            Session::flash('message','Guardado Correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Ha ocurrido un error');
            Session::flash('class','danger');
        }
        
        return redirect('consultar_conceptos');
    }
}
