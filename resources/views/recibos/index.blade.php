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
@section('titulo') Recibos 
@endsection
@section('tituloModulo')
Recibos <i class="fa fa-home"></i>
@endsection

@section ('botones')
@if(Auth::user()->tipo==3)
  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>  
@else
   <a href="#" data-toggle="modal" data-target="#modalFechas"  class="btn btn-light"><i class="fa fa-file-pdf-o"></i>Reporte de Ventas</a>
@endif
@endsection
@section('panelBotones')

  <li class="checkbox checkbox-primary">
  @if(Auth::user()->tipo==3)
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i> Crear Nuevo</a>
  @else
    <a href="#" data-toggle="modal" data-target="#modalFechas"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i>Reporte de Ventas</a>
  @endif
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
                        <th>Paciente</th>
                        <th>Pago</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($recibos as $recibo)
                      @if($recibo->estatus==1)
                        <tr class="info">
                      @elseif($recibo->estatus==3)
                        <tr class="danger">
                        @elseif($recibo->estatus==2)
                        <tr class="success">
                        @elseif($recibo->estatus==4)
                        <tr class="warning">
                      @endif
                        <td>{{$recibo->id}}</td>
                        @if(Auth::user()->tipo<=2)
                          <td>{{$recibo->unidad->nombre}}</td>
                        @endif
                        <td>{{$recibo->paciente->nombre}}</td>
                       
                        <td>{{$recibo->tipo_pago}}</td>
                        <td>${{number_format($recibo->cantidad,2)}}</td>
                        <td>{{$recibo->fecha}}</td>
                         @if($recibo->estatus==1)
                          <td>Emitido</td>
                        @elseif($recibo->estatus==2)
                         <td>Pagado</td>
                        @elseif($recibo->estatus==3)
                         <td>Credito</td>
                        @elseif($recibo->estatus==4)
                         <td>Conciliando</td>
                         @elseif($recibo->estatus==5)
                         <td>Finalizado</td>
                        @endif
                         <td>
                        @if($recibo->estatus==1)

                       <button  href="#" data-toggle="modal" data-target="#modal{{$recibo->id}}" class="btn btn-rounded btn-icon btn-info"><i title="Terminar sesión" class="fa fa-times"></i></button>

                           <!-- Modal -->
                          
                           <div class="modal fade" id="modal{{$recibo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Confirmación</h4>
                                </div>
                                <div class="modal-body">
                                  <H5>¿Estas seguro que desea terminar <br>
                                  la sesión y generar el recibo?</H5>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                  <a type="button"  href="{{route('terminarReciboGerente',$recibo->id)}}"  class="btn btn-success">Aceptar</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End Modal Code -->
                          <button  href="#" data-toggle="modal" data-target="#cancelar{{$recibo->id}}" class="btn btn-rounded btn-icon btn-danger"><i title="Terminar sesión" class="fa fa-trash"></i></button>
                        
                           <!-- Modal -->
                          
                           <div class="modal fade" id="cancelar{{$recibo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Confirmación</h4>
                                </div>
                                <div class="modal-body">
                                  <H5>¿Estas seguro que desea Cancelar el recibo?</H5>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                  <a type="button"  href="{{route('cancelarReciboGerente',$recibo->id)}}"  class="btn btn-success">Aceptar</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End Modal Code -->
                       
                        @elseif($recibo->estatus==3)
                          <button  href="#" data-toggle="modal" data-target="#modal{{$recibo->id}}" class="btn btn-rounded btn-icon btn-danger"><i title="Liquidar Recibo" class="fa fa-money"></i></button>
                           <!-- Modal -->
                          
                           <div class="modal fade" id="modal{{$recibo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Confirmación</h4>
                                </div>
                                <div class="modal-body">
                                  <H5>¿Estas seguro que deseas liquidar la deuda producida por el recibo?</H5>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                  <a type="button"  href="{{route('liquidarReciboGerente',$recibo->id)}}" class="btn  btn-success">Aceptar</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End Modal Code -->
                          
                        @elseif($recibo->estatus==2)
                          <a type="button" target="_blank" href="{{route('reciboPdf',$recibo->id)}}"  class="btn btn-rounded btn-icon btn-success"><i title="Imprimir comprobante" class="fa fa-print"></i></a>
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
         <div class="modal fade" id="modalFechas" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reporte de Recibos </h4>
              </div>
                
              <div  class="modal-body">   
                <div class="form-group">
                  <h5>Rango de fechas del reporte</h5>
                    <div class="control-group">
                      <div class="controls">
                       <div class="input-prepend input-group">
                         <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                         <input type="text" id="date-range-picker" name="fechas" class="form-control" value="" /> 
                       </div>
                      </div>
                    </div>
                </div>
               <div  class="form-group">

                  <div class="row">
                  <div class="col-sm-3"> 
                  <label>Unidad</label> 
                    <select name="usuario" id="usuarioFechas" onchange="pacientesUnidad();" class="selectpicker form-control form-control" >
                    <option value="0">Todas</option>
                      @foreach($usuarios as $usuario)
                        
                        <option value="{{$usuario->unidad_id}}">{{$usuario->unidad->nombre}}</option>
                      @endforeach 
                    </select>  
                    
                  </div>
                  <div class="col-sm-3"> 
                    <label>Paciente</label> 
                    <select name="paciente" id="usuarioPacientes" class=" form-control form-control" >
                    
                    <option value="0">Todas</option>
                      
                    </select>  
                    
                  </div>
                  <div class="col-sm-3">
                    <label>Tipo de pago</label> 
                    <select name="metodoPago" id="metodoPago" class=" form-control form-control" >
                    <option>Efectivo</option>
                    <option>Credito</option>
                    <option>Hospital</option>
                    <option>Cortecía</option>
                      
                    </select>  
                    
                  </div>
                  <div class="col-sm-3">
                    <button  class="btn btn-default pull-right" style="margin-top: 8%" onclick="FechasRecibos();" >Obtener PDF</button>
                  </div>
                  <br><br><br> 
                  <div class="col-sm-8 col-sm-offset-2"  id="pdfFechas">   
                  <br>
                    
                  </div> 
                </div>
                </div>
              </div>      
            
                <div class="modal-footer">
                  <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                   
                </div>
            </div>
          </div>
        </div>

      <!-- End Modal Code -->    
                  <!-- Modal -->
        <div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Recibo</h4>
              </div>
              <form class="form-horizontal" role="form"  method="POST" action="{{ route('guardarReciboGerente') }}">
                {!! csrf_field() !!}  
                <div class="modal-body">
                  <div class="modal-body">
                    <div  class="form-group">
                      <label class="col-sm-2 control-label form-label">Paciente: </label>
                      <div class="col-sm-10">
                        <select name="paciente_id" id="paciente" onchange="datosPaciente();" class="selectpicker form-control form-control">
                            <option value="0">Seleccionar paciente</option>
                            @foreach($pacientes as $paciente)
                              <option value="{{$paciente->id}}">{{$paciente->nombre}}</option>
                            @endforeach
                          </select>                  
                      </div>
                    </div>
                    <div  class="form-group">
                      <label class="col-sm-2 control-label form-label">Unidad: </label>
                      <div class="col-sm-10">
                        <select name="unidad_id" class="selectpicker form-control form-control">

                            <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                          </select>                  
                      </div>
                    </div>
                                    
                  
                    <div class="form-group">
                        <label " class="col-sm-2 control-label form-label">Cantidad: </label>
                        <div class="col-sm-10">
                          <input type="number" pattern="[0-9]{10}"  id="cantidad" name="cantidad" step=".1" value="1020" placeholder="Cantidad" min="0"  class="form-control form-control">
                        </div>
                    </div>
                    
                     <div  class="form-group">
                      <label class="col-sm-2 control-label form-label">Tipo de pago:</label>
                      <div class="col-sm-10">
                        <select name="tipo_pago" id="tipoPago" onclick="pago();" class=" form-control form-control" required>
                          </select>                  
                      </div>
                    </div>
                     <div class="form-group">
                      <label " class="col-sm-2 control-label form-label">Folio: </label>
                      <div class="col-sm-10">
                        <input type="number"   name="folio"  placeholder="Folio de recibos anteriores" min="0" class="form-control form-control">
                      </div>
                  </div>
                    <input type="hidden" id="beneficio" value="0" name="beneficio_id">
                </div>
                <div id="loading" class="modal-footer">
                  <button type="button"   class="btn btn-white" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-default" id="guardar" onclick="enviar();" disabled>Iniciar Sesión</button>
                 
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
    var cantidad=0;
    conceptos();
} );
$(document).ready(function() {
    $('#date-range-picker').daterangepicker(null, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
  });
}
function FechasRecibos(){
    
  
  $('#pdfFechas').html('<br><embed   src="../reporteRecibosPdf?unidad='+$('#usuarioFechas').val()+'&paciente='+$('#usuarioPacientes').val()+'&metodoPago='+$('#metodoPago').val()+'&fechas='+$('#date-range-picker').val()+'" width="100%" height="500px">')
  }
function pago() {
  
  if($('#tipoPago').val()=="Efectivo" || $('#tipoPago').val()=="Credito" || $('#tipoPago').val()=="Hospital"){
        $('#cantidad').val(1020).attr('readonly',false);
    }
  else{
      if($('#tipoPago').val()=="Cortecía"){
        $('#cantidad').val(0).attr('readonly',true);
      }
      else{
       $('#cantidad').val(cantidad).attr('readonly',true);
      
      }
    }
}

function pacientesUnidad(){
  $.ajax({
        type: "GET",
        url:'pacientesUnidad?id='+$('#usuarioFechas').val(),
        dataType:"json",
        success: llegada,
      });
  function llegada(data){
    $('#usuarioPacientes').empty();
        $('#usuarioPacientes').append($('<option>', {
            value: '0',
            text: 'Todos',
             }));
    $.each(data, function(i,p) {
            $('#usuarioPacientes').append($('<option>', {
            value: p.id,
            text: p.nombre
             }));
          //console.log(p.pivot.precio);
        });
  }
}
function conceptos(){
  $.ajax({
        type: "GET",
        url:'obtenerConceptos',
        dataType:"json",
        success: llegada,
      });
  function llegada(data){
    $.each(data, function(i,p) {
            $('#metodoPago').append($('<option>', {
            value: p.nombre,
            text: p.nombre
             }));
          //console.log(p.pivot.precio);
        });
  }
}
function datosPaciente(){
    
    var paciente =$('#paciente').val();
    //alert(paciente);
    if(paciente!=0){
      $.ajax({
        type: "GET",
        url:'datosPaciente/'+paciente,
        dataType:"json",
        success: llegada,
      });
    }else{
      $('#guardar').attr('disabled',true);
    }
    function llegada(data){
      $('#guardar').attr('disabled',false);
      if(jQuery.isEmptyObject(data)){
        $('#tipoPago').empty();
        $('#tipoPago').append($('<option>', {
            value: 'Efectivo',
            text: 'Efectivo',
             }));
        $('#tipoPago').append($('<option>', {
            value: 'Credito',
            text: 'Credito',
             }));
        $('#tipoPago').append($('<option>', {
            value: 'Hospital',
            text: 'Hospital',
             }));
        $('#tipoPago').append($('<option>', {
            value: 'Cortecía',
            text: 'Cortecía',
             }));
        $('#cantidad').val(1020).attr('readonly',false);
        $('#beneficio').val(0);
      }
      else{
        $('#tipoPago').empty();

        var precioUnitario=0;
        precioUnitario=parseFloat(data.cantidad)/parseFloat(data.sesiones);
        cantidad=precioUnitario;
        $('#cantidad').val(precioUnitario.toFixed(2)).attr('readonly',true);
        $('#tipoPago').append($('<option>', {
            value: data.concepto.nombre+' ('+(parseInt(data.sesiones_realizadas)+1)+' de '+data.sesiones+')',
            text: data.concepto.nombre+' ('+(parseInt(data.sesiones_realizadas)+1)+' de '+data.sesiones+')',
             }));
        $('#tipoPago').append($('<option>', {
            value: 'Efectivo',
            text: 'Efectivo',
             }));
        $('#tipoPago').append($('<option>', {
            value: 'Hospital',
            text: 'Hospital',
             }));
        $('#tipoPago').append($('<option>', {
            value: 'Cortecía',
            text: 'Cortecía',
             }));
        $('#beneficio').val(data.id);
      }
      
     
    }
}
</script>


@stop