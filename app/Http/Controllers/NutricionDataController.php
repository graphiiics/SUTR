<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\NutricionData;
use App\Paciente;
//use Barryvdh\DomPDF\Facade as PDF;
use PDF;

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
        $pacientes= Paciente::where('estatus','!=',3)->get();
        return view('nutricion/index',['pacientes' => $pacientes]);
    }

    public function guardarHojaNutricion(Request $request)
    {
        $hoja= new NutricionData($request->all());
        if($hoja->save()){
            Session::flash('message','Paciente registrado correctamente');
            Session::flash('class','success');
        }else{
            Session::flash('message','Error al registrar paciente');
            Session::flash('class','danger');
        }
        switch (Auth::user()->tipo) {
            case 4:
                return redirect('nutriologo/reporte-nutricion');
                break;
            
        
        }
    }

    public function reporteNutricionPdf(Request $request){
        $pdf = PDF::loadView('nutricion/reportes');
        return $pdf->download();

        //return view('nutricion/reportes');
    }

    
}
