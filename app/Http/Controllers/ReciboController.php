<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Recibo;

class ReciboController extends Controller
{
    //
   	public function consultar_recibos(){

        $recibos=Recibo::All();
        return view('super_views.consultar_recibos',compact('recibos'));
    }
}
