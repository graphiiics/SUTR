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
@section('titulo') Unidades 
@endsection
@section('tituloModulo')
Unidades <i class="fa fa-home"></i>
@endsection
@section ('botones')

<a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i>Nueva unidad</a>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i>Nueva unidad</a>
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
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Total de pacientes</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($unidades as $unidad)
                      <tr>
                        <td>{{$unidad->id}}</td>
                        <td>{{$unidad->nombre}}</td>
                        <td>{{$unidad->direccion}}</td>
                        <td>{{count($unidad->pacientes)}}</td>
                        <td><a  href="#" data-toggle="modal" data-target="#modal{{$unidad->id}}" class="btn btn-rounded btn-light">Editar usuario</a>
                             <!-- Modal -->
                                <div class="modal fade" id="modal{{$unidad->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar {{$unidad->nombre}}</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarUnidad',$unidad->id) }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text"  name="nombre" value="{{$unidad->nombre}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Dirección: </label>
                                                <div class="col-sm-10">
                                                  <input type="text"  name="direccion" value="{{$unidad->direccion}}" class="form-control form-control-radius">
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
                      <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('guardarUnidad') }}">
                        {!! csrf_field() !!}  
                        <div class="modal-body">
                            <div class="form-group">
                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="nombre"  class="form-control form-control-radius" placeholder="Nombre de la unidad" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label " class="col-sm-2 control-label form-label">Correo: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="direccion"  class="form-control form-control-radius"  placeholder="Dirección de la unidad" required>
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


