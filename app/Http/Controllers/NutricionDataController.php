<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\NutricionData;
use App\Paciente;
use App\Unidad;
use PDF;
use Session;
use Auth;

class NutricionDataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $reportes =  NutricionData::all();
        $unidades = Unidad::all();
        $pacientes = Paciente::where('estatus','!=',3)->get();
        return view('nutricion/index',['pacientes' => $pacientes,'reportes' => $reportes]);
    }

    public function guardarHojaNutricion(Request $request)
    {
        $hoja= new NutricionData($request->all());
        if($hoja->save()){
            Session::flash('message','Hoja de nutrición guardada correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Error al guardar la hora de nutrición paciente');
            Session::flash('class','danger');
        }
        switch (Auth::user()->tipo) {
            case 4:
                return redirect('nutriologo/reporte-nutricion');
                break;        
        }
    }

    public function reporteNutricionPdf(Request $request,$paciente){
        $reporteData = NutricionData::where('nutricion_datas.id','=',$paciente)->leftJoin('pacientes', 'paciente_id','=','pacientes.id')->first();
        $pdf = PDF::loadView('nutricion/reportes',['reporte' => $reporteData]);
        return $pdf->stream('reporte.pdf');
        //return view('nutricion/reportes',['reporte' => $reporteData]);
    }

    
}
