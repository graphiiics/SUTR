<?php
  if(Auth::user()->tipo==1)
  {
    $variable = "layouts.super_admin";
  }
  elseif(Auth::user()->tipo==2)
  {
    $variable = "layouts.admin";
  }
  elseif(Auth::user()->tipo==3)
  {
    $variable = "layouts.gerente";
  }
?>
@extends("$variable")
@section('titulo') Pacientes 
@endsection
@section('tituloModulo')
Pacientes <i class="fa fa-home"></i>
@endsection

@section ('botones')

  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>  

@endsection
@section('panelBotones')

  <li class="checkbox checkbox-primary">
  
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
  
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
                        @if(Auth::user()->tipo<=2)
                          <th>Unidad</th>
                        @endif
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Celular</th>
                        <th>última sesión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($pacientes as $paciente)
                      @if($paciente->estatus==1)
                       <tr>
                      @elseif($paciente->estatus==2)
                         <tr class="warning" >
                      @endif
                     
                        <td>{{$paciente->id}}</td>
                        @if(Auth::user()->tipo<=2)
                          <td>{{$paciente->unidad->nombre}}</td>
                        @endif
                        <td>{{$paciente->nombre}}</td>
                        <td>{{$paciente->direccion}}</td>
                        <td>{{$paciente->celular}}</td>
                        @if(count($paciente->recibos)>0)
                          
                          <td>{{$paciente->recibos[count($paciente->recibos)-1]->fecha}}</td>
                          
                        @else
                          <td>No tiene sesiones</td>
                        @endif
                         <td>
                         <a  href="#" data-toggle="modal" data-target="#modal{{$paciente->id}}" class="btn btn-rounded btn-light">Editar</a>
                            <!-- Modal -->
                                <div class="modal fade" id="modal{{$paciente->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar {{$paciente->nombre}}</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarPacienteGerente',$paciente->id) }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre" value="{{$paciente->nombre}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div  class="form-group">
                                              <label class="col-sm-2 control-label form-label">Unidad: </label>
                                              <div class="col-sm-10">
                                                <select name="unidad_id" class="selectpicker form-control form-control-radius">
                                                  @if(Auth::user()->tipo<=2) 
                                                    @foreach($unidades as $unidad)
                                                      <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                                    @endforeach
                                                  @else
                                                    <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                                                  @endif
                                              
                                                  </select>                  
                                              </div>
                                            </div>
                                                            
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Dirección: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="direccion" placeholder="Calle,Número,Colonia,Municipio,Estado" value="{{$paciente->direccion}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Teléfono: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" pattern="[0-9]{10}"  name="telefono"  placeholder="Teléfono de casa" min="0" value="{{$paciente->telefono}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Celular: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" pattern="[0-9]{10}"  name="celular" placeholder="Teléfono Celular" min="0" value="{{$paciente->celular}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                           
                                             
                                            
                                           
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          <button type="submit"  class="btn btn-default"  >Guardar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                              <!-- End Modal Code -->
                              @if($paciente->estatus==1 && Auth::user()->tipo==3)
                                <a  href="{{route('suspenderPacienteGerente',$paciente->id)}}" class="btn btn-rounded btn-icon btn-warning" title="Suspender paciente"><i class="fa fa-close"></i></a>
                              
                              @elseif($paciente->estatus==2 && Auth::user()->tipo==3)
                                 <a  href="{{route('activarPacienteGerente',$paciente->id)}}" class="btn btn-rounded btn-icon btn-success" title="Activar paciente"><i class="fa fa-check-square-o"></i></a>
                              @elseif($paciente->estatus==2 && Auth::user()->tipo<3)
                                 <a  href="{{route('eliminarPaciente',$paciente->id)}}" class="btn btn-rounded  btn-icon btn-danger" title="Eliminar paciente"><i class="fa fa-trash"></i></a>
                              @endif
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
                <h4 class="modal-title">Nuevo paciente</h4>
              </div>
              <form class="form-horizontal" role="form"  method="POST" action="{{ route('guardarPacienteGerente') }}">
                {!! csrf_field() !!}  
                <div class="modal-body">
                    <div class="modal-body">
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre"  class="form-control form-control-radius" required="">
                                                </div>
                                            </div>
                                            <div  class="form-group">
                                              <label class="col-sm-2 control-label form-label">Unidad: </label>
                                              <div class="col-sm-10">
                                                <select name="unidad_id" class="selectpicker form-control form-control-radius">
                                                    @if(Auth::user()->tipo==3)
                                                    <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                                                    @else
                                                      @foreach($unidades as $unidad)
                                                        <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                                      @endforeach 
                                                    @endif
                                                  </select>                  
                                              </div>
                                            </div>
                                                            
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Dirección: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="direccion" placeholder="Calle,Número,Colonia,Municipio,Estado"  class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Teléfono: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" pattern="[0-9]{10}"  name="telefono"  placeholder="Telefono de casa" min="0"  class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Celular: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" pattern="[0-9]{10}"  name="celular" placeholder="Teléfono Celular" min="0"  class="form-control form-control-radius">
                                                </div>
                                            </div>
                   
                    
                </div>
                <div id="loading" class="modal-footer">
                  <button type="button"   class="btn btn-white" data-dismiss="modal">Cerrar</button>
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