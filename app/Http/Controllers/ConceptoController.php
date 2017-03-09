<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Concepto;
use Session;
use Auth;

class ConceptoController extends Controller
{
    //
    public function index(){

        $conceptos = Concepto::orderBy('id', 'asc')->get();
        return view('conceptos/index',compact('conceptos'));
    }
    

    public function guardarConcepto(Request $request)
    {
       $concepto= new Concepto($request->all());
        $concepto->estatus=1;
        if($concepto->save()){
            
            Session::flash('message','Unidad Creada Exitosamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Error ');
            Session::flash('class','success');
        }
        switch (Auth::user()->tipo) {
            case 1:
                return redirect('superAdmin/conceptos');
                break;
            case 2:
                return redirect('admin/conceptos');
                break;
        }
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

    public function obtenerConceptos(){
        return Concepto::all();
    } 
}
