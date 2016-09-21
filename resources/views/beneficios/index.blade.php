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
@section('titulo') Beneficios 
@endsection
@section('tituloModulo')
Beneficios <i class="fa fa-home"></i>
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
                        <th>Empresa</th>
                        <th>Concepto</th>
                        <th>Paciente</th>
                        <th>Cantidad</th>
                        <th>Sesiones</th>
                        <th>S. Realizadas</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beneficios as $beneficio)
                      <tr>
                        <td>{{$beneficio->id}}</td>
                        @if(Auth::user()->tipo<=2)
                          <td>{{$beneficio->unidad->nombre}}</td>
                        @endif
                        <td>{{$beneficio->empresa->razon_social}}</td>
                        <td>{{$beneficio->concepto->nombre}}</td>
                         <td>{{$beneficio->paciente->nombre}}</td>
                        @if(is_int($beneficio->cantidad))
                          <td>${{$beneficio->cantidad}}</td>
                        @else
                           <td>${{$beneficio->cantidad}}.00</td>
                        @endif
                        <td>{{$beneficio->sesiones}}</td>
                        <td>{{$beneficio->sesiones_realizadas}}</td>
                        @if($beneficio->estatus==1)
                          <td>Activo</td>
                        @elseif($beneficio->estatus==2)
                          <td>Completado</td>
                        @endif
                        
                       
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
                <h4 class="modal-title">Nuevo Beneficio</h4>
              </div>
              @if(Auth::user()->tipo==2)
                <form class="form-horizontal" role="form"  method="POST" action="{{ route('guardarBeneficio') }}">
              @elseif(Auth::user()->tipo==3)
                <form class="form-horizontal" role="form"  method="POST" action="{{ route('guardarBeneficioGerente') }}">
              @endif
                {!! csrf_field() !!}  
                <div class="modal-body">
                    <div class="modal-body">
                   <div  class="form-group">
                    <label class="col-sm-2 control-label form-label">Paciente: </label>
                    <div class="col-sm-10">
                      <select name="paciente_id" class="selectpicker form-control form-control-radius">
                          @foreach($pacientes as $paciente) 
                            <option value="{{$paciente->id}}">{{$paciente->nombre}}</option>
                          @endforeach
                        </select>                  
                    </div>
                  </div>
                  <div  class="form-group">
                    <label class="col-sm-2 control-label form-label">Unidad: </label>
                    <div class="col-sm-10">
                      <select name="unidad_id" class="selectpicker form-control form-control-radius">
                         @if(!Auth::user()->tipo==3)
                          @foreach($unidades as $unidad) 
                            <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                          @endforeach
                        @else
                           <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                        @endif

                        </select>                  
                    </div>
                  </div>
                   <div  class="form-group">
                    <label class="col-sm-2 control-label form-label">Empresa: </label>
                    <div class="col-sm-10">
                      <select name="empresa_id" class="selectpicker form-control form-control-radius">
                          @foreach($empresas as $empresa) 
                            <option value="{{$empresa->id}}">{{$empresa->razon_social}}</option>
                          @endforeach
                        </select>                  
                    </div>
                  </div>
                  <div  class="form-group">
                    <label class="col-sm-2 control-label form-label">Concepto: </label>
                    <div class="col-sm-10">
                      <select name="concepto_id" class="selectpicker form-control form-control-radius">
                          @foreach($conceptos as $concepto) 
                            <option value="{{$concepto->id}}">{{$concepto->nombre}}</option>
                          @endforeach
                        </select>                  
                    </div>
                  </div>
                                  
                  <div class="form-group">
                      <label " class="col-sm-2 control-label form-label">sesiones: </label>
                      <div class="col-sm-10">
                        <input type="number" name="sesiones" placeholder="Sesiones asignads"  min="1" class="form-control form-control-radius">
                      </div>
                  </div>
                  <div class="form-group">
                      <label " class="col-sm-2 control-label form-label">Cantidad: </label>
                      <div class="col-sm-10">
                        <input type="number"   name="cantidad"  placeholder="Cantidad total de beneficio" min="0" step=".1" class="form-control form-control-radius">
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