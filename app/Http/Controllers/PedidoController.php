<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pedido;
use App\Producto;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$pedidos = Pedido::orderBy('id', 'asc')->get();
    	$productos= Producto::orderBy('id', 'asc')->get();
    	return view('pedidos/index',compact('pedidos','productos'));
    }
}
