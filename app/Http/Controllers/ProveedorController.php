<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Proveedor;

class ProveedorController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$proveedores = Proveedor::orderBy('id', 'asc')->get();
    	return view('proveedores/index',compact('proveedores'));
    }
}
