<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Unidad;
use Auth;
use Session;
use App\Producto;

class UnidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	
    	$unidades = Unidad::orderBy('id', 'asc')->get();
    	return view('unidades/index',compact('unidades'));
    }

    public function editarUnidad(Unidad $unidad,Request $request)
    {
    	if($unidad->update(['nombre'=>$request->input('nombre'),'direccion'=>$request->input('direccion')])){
            Session::flash('message','Datos actualizados correctamente');
            Session::flash('class','success');
    	}else{
            Session::flash('message','Error al actualizar los datos');
            Session::flash('class','Danger');
    	}
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/unidades');
	    		break;
	    	case 2:
	    		return redirect('admin/unidades');
	    		break;    	
   		}
    }
    public function guardarUnidad(Request $request)
    {
    	$unidad= new Unidad($request->all());
    	$unidad->estatus=1;
    	if($unidad->save()){
            foreach (Producto::all() as $producto){
             $producto->unidades()->attach($unidad->id,['cantidad' => 0,'stock_minimo' =>0,'producto_id'=>$producto->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            }
            Session::flash('message','Unidad Creada Exitosamente');
            Session::flash('class','success');
    	}else{
            Session::flash('message','Error ');
            Session::flash('class','success');
    	}
    	switch (Auth::user()->tipo) {
	    	case 1:
	    		return redirect('superAdmin/unidades');
	    		break;
	    	case 2:
	    		return redirect('admin/unidades');
	    		break;
	    	
   		}
    }
    public function eliminarUnidad(Unidad $unidad)
    {
        if(count($unidad->productos)>0){
            if($unidad->productos()->detach()){
                if($unidad->delete()){
                    Session::flash('message','Unidad eliminada Exitosamente');
                    Session::flash('class','success');
                }else{
                    Session::flash('message','Error al eliminar la unidad');
                    Session::flash('class','danger');
                }
            }
            else{
                Session::flash('message','Error al eliminar los productos de la unidad');
                Session::flash('class','danger');
            }
        }
        else{
            if($unidad->delete()){
                Session::flash('message','Unidad eliminada Exitosamente');
                Session::flash('class','success');
            }else{
                Session::flash('message','Error al eliminar la unidad');
                Session::flash('class','danger');
            }
        }
        switch (Auth::user()->tipo) {
            case 1:
                return redirect('superAdmin/unidades');
                break;
            case 2:
                return redirect('admin/unidades');
                break;
            
        }
    }
}
