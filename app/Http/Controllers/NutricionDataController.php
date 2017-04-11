<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\NutricionData;

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
        return view('nutricion/index');
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
}
