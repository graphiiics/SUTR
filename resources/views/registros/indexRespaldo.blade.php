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
@section('titulo') Registro 
@endsection
@section('tituloModulo')
Registro <i class="fa fa-home"></i>
@endsection
@section ('botones')
  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i> Crear Nuevo</a>
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
                <th>Usuario</th>
                <th>Unidad</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Observaciones</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registros as $registro)
                <tr>
                  <td>{{$registro->id}}</td>
                  <td>{{$registro->user->name}}</td>
                  <td>{{$registro->unidad->nombre}}</td>
                  <td>{{$registro->fecha}}</td>
                  @if($registro->tipo==1)
                    <td>Entrada</td>
                  @elseif($registro->tipo==2)
                    <td>Salida</td>
                  @endif
                  <td>{{$registro->observaciones}}</td>
                  <td><a  href="#" data-toggle="modal" data-target="#modal{{$registro->id}}" class="btn btn-rounded btn-light">Ver detalles</a>
                  <!-- Modal -->
                    <div class="modal fade" id="modal{{$registro->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Detalles del registro</h4>
                          </div>
                          <div class="modal-body">
                             <table class="table-striped ">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>precio</th>
                                    <th>Cantidad</th>
                                    <th>Categoría</th>                            
                                  </tr>
                                </thead>
                                <tbody id="modalTableBody" class="">
                                  @foreach ($registro->productos as $num =>$producto)
                                    <tr>
                                      <td>{{$num+1}}</td>
                                      <td>{{$producto->id}}</td>
                                      <td>{{$producto->nombre}}</td>
                                      @if($producto->presentacion=="Suplemento")
                                        <td>${{$producto->precio_venta}}</td> 
                                      @else
                                        <td>No disponible</td> 
                                      @endif
                                      @if($producto->pivot->cantidad==1)
                                         <td>{{$producto->pivot->cantidad}} {{$producto->presentacion}}</td>
                                      @else
                                         <td>{{$producto->pivot->cantidad}} {{$producto->presentacion}}s</td>
                                      @endif
                                      <td>{{$producto->categoria}}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>                  
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                            <a href="{{route('registroPdf',$registro->id)}}"  target="_blank" type="button" class="btn btn-default">Imprimir</a>
                          </div>
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
              <h4 class="modal-title">Nuevo Registro</h4>
            </div>
           @if(Auth::user()->tipo==1)
            <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarRegistro') }}">
             @elseif(Auth::user()->tipo==2)
            <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarRegistro') }}">
             @elseif(Auth::user()->tipo==3)
            <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarRegistroGerente') }}">
            @endif
              {!! csrf_field() !!}  
              <div  class="modal-body">
                                                              
                  <div  class="form-group">
                    <label class="col-sm-2 control-label form-label">Unidad: </label>
                    <div class="col-sm-10">
                      <select name="unidad" class="form-control ">
                          {{-- @if(Auth::user()->tipo<=2)
                          @foreach($unidades as$unidad)
                            <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                          @endforeach
                        @else --}}
                          <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                     {{--    @endif --}}
                        </select>                  
                    </div>
                  </div>
                  <div  class="form-group">
                    <label class="col-sm-2 control-label form-label">Tipo: </label>
                    <div class="col-sm-10">
                      <select name="tipo"  id="tipo" onchange="cantidadUnidad();" class="form-control form-control">
                          <option value="1">Entrada</option>
                          <option value="2">Salida</option>
                        </select>                  
                    </div>
                  </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label form-label">Observaciones: </label>
                      <div class="col-sm-10">
                      <input type="text" name="observaciones" class="form-control form-control">             
                    </div>
                    </div>
                  <div>
                    <div class="form-group col-lg-8 md-8 sm-8">
                        <label class="col-lg-4 control-label form-label">Producto:</label>
                        <div class="col-lg-8">
                          <select id="nProducto" onchange="cantidadUnidad();" class="form-control form-control">
                            @foreach($productos as $producto)
                            <option value="{{$producto->id}}-{{$producto->nombre}}" >{{$producto->nombre}}</option>
                            @endforeach
                          </select>     
                        </div>
                    </div>
                   
                    <div class="form-group col-lg-4 md-4 sm-4">
                        <div class="col-lg-12">
                          <input type="number"   id="cProducto"  value="0"  min="0"  max="100" class="form-control form-control" >
                        </div>
                    </div>
                     <a  href="#" id="agregar" onclick="AgregarCampos();" type="button" class="btn btn-rounded btn-success   btn-icon"><i class="fa fa-plus"></i></a>
                  </div>

                  <div id="bodyModal">
                  <input type="hidden" id="totalProductos" name="totalProductos" value="0">
                  </div>
                
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="eliminarCampos();" class="btn btn-danger">Limpiar</button>
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
     cantidadUnidad();
} );
</script>
<script type="text/javascript">
  var nextinput = 0;

  function AgregarCampos(){
    var producto=$('#nProducto').val();
    var cantidad=parseInt($('#cProducto').val());
    var cantidadMax=parseInt($('#cProducto').prop('max'));
    nextinput++;
    $("#tipo").attr('disabled',true);
    $('#bodyModal').append('<input type="hidden"  name="tipo" value="'+$('#tipo').val()+'">');
    if($('#tipo').val()==2 && cantidad>cantidadMax){
        cantidad=cantidadMax;

    }
     
    campo = '<div id="campo'+nextinput+'"><div class="form-group col-lg-8 md-8 sm-8"><label  class="col-lg-4 control-label form-label">Producto '+(nextinput)+':</label><div class="col-lg-8"><input type="text" id="producto'+nextinput+'" name="producto'+nextinput+'" value="'+producto.substring(producto.indexOf('-')+1)+'" class="form-control " disabled > <input type="hidden" name="producto'+nextinput+'" value="'+producto.substring(0,producto.indexOf('-'))+'"></div></div><div class="form-group col-lg-4 md-4 sm-4"><div class="col-lg-12"><input type="number" value="'+cantidad+'" min="1" max="'+cantidadMax+'" name="cantidad'+nextinput+'" min="1" class="form-control " required ></div></div><div class="form-group col-lg-2 md-2 sm-2"></div>  </div>';
     
    if(producto!=null){
        $('#totalProductos').val(nextinput);
        $("#nProducto option[value='"+producto+"']").remove();
        $("#bodyModal").prepend(campo);
        $('#cProducto').val();
        $('#nProducto').val();
        cantidadUnidad();
    }
    else{
      $('#agregar').attr("disabled", true);
    }
  }
  function eliminarCampos(){
    $.ajax({
        type: "GET",
        url:'../productosUnidad',
        success: llegada,
      });
    function llegada(data){
      $('#nProducto').empty();
     $.each(data, function(i,p) {
            $('#nProducto').append($('<option>', {
            value: p.id+'-'+p.nombre,
            text: p.nombre
             }));
          //console.log(p.pivot.precio);
        });

    }
    for (var i = 1; i <= nextinput; i++) {
      
      $('#campo'+i).remove();
      
    }
    $("#tipo").attr('disabled',false);
    nextinput=0;
    
  }
  function cantidadUnidad() {
if(parseInt($('#tipo').val())==2){
    var producto=$("#nProducto").val();
      $.ajax({
        type: "GET",
        url:'cantidadUnidad/'+producto.substring(0,producto.indexOf('-')),
        success: llegada,
      });
    function llegada(data){
     if(data>0 ){
        $("#cProducto").attr('max',data);
        $("#cProducto").val(1);
     }
    else{
      $("#nProducto option[value='"+producto+"']").remove();
      cantidadUnidad();
    }

    }
  }
  else{
    $("#cProducto").attr('max',100);
    $("#cProducto").val(1);
  }
 }
 function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});
}
</script>

@stop