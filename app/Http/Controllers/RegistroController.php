<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Registro;

class RegistroController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$registros = Registro::orderBy('id', 'asc')->get();
    	return view('registros/index',compact('registros'));
    }
}
