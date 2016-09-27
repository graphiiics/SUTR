<?php
  if(Auth::user()->tipo==1)
  {
    $variable = "layouts.super_admin";
  }
  elseif(Auth::user()->tipo==2)
  {
    $variable = "layouts.admin";
  }
?>
@extends("$variable")
@section('titulo') Usuarios 
@endsection
@section('tituloModulo')
Usuarios <i class="fa fa-home"></i>
@endsection
@section ('botones')

<a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i>Nuevo usuario</a>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i>Nuevo usuario</a>
  </li>
@endsection
 @section('contenido')
        <!-- Start Panel -->
    <div class="col-md-12 col-lg-12">
     @if(Session::has('message'))
          <div  class="alert alert-{{ Session::get('class') }} alert-dismissable kode-alert-click">
                <strong>{{ Session::get('message')}} </strong>
          </div>
        @endif
      <div class="panel panel-default">
        <div class="panel-title">
         
        </div>
        <div class="panel-body table-responsive">

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefóno</th>
                        <th>Estado</th>
                        <th>Unidad</th>
                        <th>Tipo</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                      <tr>
                        <td>{{$usuario->id}}</td>
                        <td> <img src="{{asset('img/perfil/'.$usuario->foto)}}" alt="img" class="img-responsive img-circle " width="60px"></td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>{{$usuario->telefono}}</td>
                        @if($usuario->estatus==1)
                          <td>Activo</td>
                        @elseif($usuario->estatus==2)
                          <td>Suspendido</td>
                        @endif
                        <td>{{$usuario->unidad->nombre}}</td>
                        @if($usuario->tipo==1)
                          <td>Super Administrador</td>
                        @elseif($usuario->tipo==2)
                          <td>Administrador</td>
                        @elseif($usuario->tipo==3)
                          <td>Gerente</td>
                        @endif
                        <td><a  href="#" data-toggle="modal" data-target="#modal{{$usuario->id}}" class="btn btn-rounded btn-light">Editar usuario</a>
                             <!-- Modal -->
                                <div class="modal fade" id="modal{{$usuario->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar {{$usuario->name}}</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarUsuario',$usuario->id) }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text"  name="name" value="{{$usuario->name}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Telefóno: </label>
                                                <div class="col-sm-10">
                                                  <input type="tel" pattern="[0-9]{10}" name="telefono" value="{{$usuario->telefono}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Estado: </label>
                                              <div class="col-sm-10">
                                                <select name="estatus" value="{{$usuario->estatus}}" class="selectpicker form-control form-control-radius">
                                                  @if($usuario->estatus==1)
                                                    <option value="1" selected>Activo</option>
                                                    <option value="2" >Suspendido</option>
                                                  @elseif($usuario->estatus==2)
                                                    <option value="1" >Activo</option>
                                                    <option value="2" selected>Suspendido</option>
                                                  @endif
                                                  </select>                  
                                              </div>
                                            </div>
                                                                                    
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Unidad: </label>
                                              <div class="col-sm-10">
                                                <select name="unidad_id" class="selectpicker form-control form-control-radius">
                                                 @foreach($unidades as $unidad)
                                                    @if($unidad->id==$usuario->unidad_id)
                                                       <option value="{{$unidad->id}}" selected >{{$unidad->nombre}}</option>
                                                    @else
                                                      <option value="{{$unidad->id}}" >{{$unidad->nombre}}</option>
                                                    @endif
                                                  @endforeach  
                                                </select>              
                                              </div>
                                            </div>
                                            
                                            
                                           
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          <button type="submit" class="btn btn-default">Guardar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                              <!-- End Modal Code -->

                        </td>
                    </tr>

                  @endforeach
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
      <!-- Modal -->
                <div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nuevo usuario</h4>
                      </div>
                      <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('guardarUsuario') }}">
                        {!! csrf_field() !!}  
                        <div class="modal-body">
                            <div class="form-group">
                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="name"  class="form-control form-control-radius" placeholder="Nombre completo" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label " class="col-sm-2 control-label form-label">Correo: </label>
                                <div class="col-sm-10">
                                  <input type="email" name="email"  class="form-control form-control-radius"  placeholder="Correo valido" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label " class="col-sm-2 control-label form-label">Telefóno: </label>
                                <div class="col-sm-10">
                                  <input type="tel" name="telefono" pattern="[0-9]{10}" class="form-control form-control-radius" placeholder="10 dígitos"  required>
                                </div>
                            </div>
                             
                            <div class="form-group">
                              <label class="col-sm-2 control-label form-label">Tipo: </label>
                              <div class="col-sm-10">
                                <select name="tipo" class="selectpicker form-control form-control-radius">
                                    @if(Auth::user()->tipo==1)
                                      <option value="2">Administrador</option>
                                      <option value="3">Gerente</option>
                                    @elseif(Auth::user()->tipo==2)
                                      <option value="3">Gerente</option>
                                    @endif
                                  </select>                  
                              </div>
                            </div>
                                                                    
                            <div class="form-group">
                              <label class="col-sm-2 control-label form-label">Unidad: </label>
                              <div class="col-sm-10">
                                <select name="unidad_id"  class="selectpicker form-control form-control-radius">
                                 @foreach($unidades as $key=> $unidad)
                                      <option value="{{$unidad->id}}" >{{$unidad->nombre}}</option>
                                  @endforeach  
                                </select>              
                              </div>
                            </div>
                            <div class="form-group">
                            <label " class="col-sm-2 control-label form-label">Foto:</label>
                                <div class="col-sm-10">
                                  <input type="file" name="foto"  class="form-control form-control-radius">
                                </div>
                            </div> 
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-default" onclick="enviar();">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

      <!-- End Modal Code -->
    
      
 
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});
}
</script>


@stop


