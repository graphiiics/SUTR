<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Unidad;
use Auth;
use Session;
use Storage;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	switch (Auth::user()->tipo) {
    		case 1:
    			$usuarios = User::orderBy('id', 'asc')->get();
    			break;
    		case 2:
    			$usuarios = User::where('tipo','>',2)->get();
    			break;
    	}
    	$unidades = Unidad::orderBy('id', 'asc')->get();
    	return view('usuarios/index',compact('usuarios','unidades'));
    }
    public function editarUsuario(User $usuario,Request $request){
    	if($usuario->update($request->all())){
    		Session::flash('message','Datos actualizados correctamente');
            Session::flash('class','success');
       }else{
             Session::flash('message','Error al actualizar los datos');
             Session::flash('class','danger');
       }
       return redirect('admin/usuarios');
    }

    public function guardarUsuario(Request $request){
    	$usuario= new User($request->all());
    	$usuario->password=bcrypt('hemodialisis');
    	$usuario->estatus=1;
        $foto=$request->file('foto');
    	if ($foto) {
    		
    		 $fileName='foto'.$request->input('name').'.'.$foto->getClientOriginalExtension();
            \Storage::disk('local')->put($fileName,  \File::get($foto)); 
    		$usuario->foto=$fileName;
		}else{
			$usuario->foto='default.png';
		}
    	if($usuario->save()){
    		Session::flash('message','Usuario creado correctamente');
            Session::flash('class','success');
       }else{
             Session::flash('message','Error al crear usuario');
             Session::flash('class','danger');
       }
       return redirect('admin/usuarios');
    }
}
