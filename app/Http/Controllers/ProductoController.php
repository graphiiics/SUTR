<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Producto;

class ProductoController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$productos = Producto::orderBy('id', 'asc')->get();
    	return view('productos/index',compact('productos'));
    }
    public function productosProveedores(){
    	$productos = Producto::orderBy('id', 'asc')->get();
    	return view('productos/productosProveedores',compact('productos'));
    }
}
