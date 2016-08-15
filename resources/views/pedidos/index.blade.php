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
@section('titulo') Pedidos 
@endsection
@section('tituloModulo')
Pedidos <i class="fa fa-home"></i>
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
                        <th>Usuario</th>
                        <th>Unidad</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                    @if($pedido->estatus==1)
                          <tr class="danger">
                        @elseif($pedido->estatus==2)
                          <tr class="warning">
                        @elseif($pedido->estatus==3)
                          <tr >
                        @endif
                        <td>{{$pedido->id}}</td>
                        <td>{{$pedido->user->name}}</td>
                        <td>{{$pedido->unidad->nombre}}</td>
                        <td>{{$pedido->fecha}}</td>
                        @if($pedido->estatus==1)
                          <td >Pendiente</td>
                        @elseif($pedido->estatus==2)
                          <td >Realizado</td>
                        @elseif($pedido->estatus==3)
                          <td>Entregado</td>
                        @endif
                        @if($pedido->comentarios==null)
                          <td >Ningún comentario</td>
                        @else
                         <td><i title="{{$pedido->comentarios}}">Mensaje</i</td>
                        @endif
                        <td><a  href="#" data-toggle="modal" data-target="#modal{{$pedido->id}}" class="btn btn-rounded btn-light">Ver detalles</a>
                            <!-- Modal -->
                                <div class="modal fade" id="modal{{$pedido->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Detalles del pedido</h4>
                                      </div>
                                      <div class="modal-body">
                                        @if(Auth::user()->tipo<3 && $pedido->estatus==1)
                                          <form class="form-horizontal" role="form" method="POST" action="{{ route('emitirPedido',$pedido->id) }}">
                                        {!! csrf_field() !!}
                                        @endif
                                         <table  class="table-striped">
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
                                            <tbody id="modalTableBody">
                                                @foreach ($pedido->productos as $num =>$producto)
                                                  <tr>
                                                    <td>{{$num+1}}</td>
                                                    <td>{{$producto->id}}</td>
                                                    <td>{{$producto->nombre}}</td>
                                                    <td>${{$producto->precio_venta}}</td>
                                                    @if(Auth::user()->tipo<3 && $pedido->estatus==1)
                                                    <td><input type="number" value="{{$producto->pivot->cantidad}}" name="cantidadEditar{{$num}}"></td>
                                                    <input type="hidden" name="productoEditar{{$num}}" value="{{$producto->id}}">
                                                     @else
                                                      @if($producto->pivot->cantidad==1)
                                                         <td>{{$producto->pivot->cantidad}} {{$producto->tipo}}</td>
                                                      @else
                                                         <td>{{$producto->pivot->cantidad}} {{$producto->tipo}}s</td>
                                                      @endif
                                                     @endif
                                                    <td>{{$producto->categoria}}</td>
                                                </tr>
                                              @endforeach
                                            </tbody>
                                        </table> 
                                       
                                         @if($pedido->estatus!=3 )
                                            <div  class="form-group">
                                                <label class="col-sm-2 control-label form-label">Comentarios: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="comentarios" id="comentarios" class=" form-control form-control-radius" >
                                                </div>
                                            </div>
                                        @endif 
                                                       
                                      </div>
                                      <div class="modal-footer">
                                        <a type="button" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                        @if($pedido->estatus==1 && $pedido->user_id==Auth::user()->id)
                                            @if(Auth::user()->tipo==1)
                                              <a  href="{{ route('eliminarPedido',$pedido->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                            @elseif(Auth::user()->tipo==2)
                                              <a  href="{{ route('eliminarPedido',$pedido->id) }}"  type="button" class="btn btn-danger">Eliminar</a>
                                            @elseif(Auth::user()->tipo==3)
                                              <a  href="{{ route('eliminarPedidoGerente',$pedido->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                            @endif
                                        @endif
                                        @if($pedido->estatus==2 && $pedido->user_id==Auth::user()->id)
                                            @if(Auth::user()->tipo==1)
                                              <a  href="{{ route('recibirPedido',$pedido->id) }}" type="button" onclick="agregarComentario({{$pedido->id}});" class="btn btn-success">Recibir Pedido</a>
                                            @elseif(Auth::user()->tipo==2)
                                              <a  href="{{ route('recibirPedido',$pedido->id) }}" type="button" onclick="agregarComentario({{$pedido->id}});" class="btn btn-success">Recibir Pedido</a>
                                            @elseif(Auth::user()->tipo==3)
                                              <a  href="{{ route('recibirPedidoGerente',$pedido->id) }}" type="button" onclick="agregarComentario({{$pedido->id}});" class="btn btn-success">Recibir Pedido</a>
                                            @endif
                                        @endif
                                        @if($pedido->estatus==1 )
                                          
                                            @if(Auth::user()->tipo==1)
                                             <button   type="submit" class="btn btn-warning">Emitir Pedido</button>
                                             </form>
                                            @elseif(Auth::user()->tipo==2)
                                              <button   type="submit" class="btn btn-warning">Emitir Pedido</button>
                                             </form>
                                            @endif
                                        @endif
                                        <a type="button"  href="{{ route('pedidoPdf',$pedido->id) }}" target="_blank" class="btn btn-default">Imprimir</a>
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
                        <h4 class="modal-title">Nuevo Pedido</h4>
                      </div>
                      @if(Auth::user()->tipo==1)
                      <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedido') }}">
                      @elseif(Auth::user()->tipo==2)
                      <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedido') }}">
                      @elseif(Auth::user()->tipo==3)
                      <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedidoGerente') }}">
                      @endif
                        {!! csrf_field() !!}  
                        <div  class="modal-body">
                                                                        
                            <div  class="form-group">
                              <label class="col-sm-2 control-label form-label">Unidad: </label>
                              <div class="col-sm-10">
                                <select name="unidad" class="selectpicker form-control form-control-radius">
                                 {{--  @if(Auth::user()->tipo<=2)
                                    @foreach($unidades as $unidad)
                                    <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                    @endforeach
                                  @else --}}
                                    <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                            {{--       @endif --}}
                                  </select>                  
                              </div>
                            </div>
                            <div  class="form-group">
                              <label class="col-sm-2 control-label form-label">Comentarios: </label>
                              <div class="col-sm-10">
                                <input type="text" name="comentarios"    class=" form-control form-control-radius" >
                              </div>
                            </div>

                            <div>
                              <div class="form-group col-lg-8 md-8 sm-8">
                                  <label " class="col-lg-4 control-label form-label">Producto:</label>
                                  <div class="col-lg-8">
                                    <select id="nProducto" onchange="cantidadAlmacen();" class="selectpicker form-control form-control-radius">
                                      @foreach($productos as $producto)
                                        @if($producto->unidades()->first()->pivot->cantidad>0) {{-- Solicita cantidad al almacen --}}
                                          <option value="{{$producto->id}}-{{$producto->nombre}}" >{{$producto->nombre}}</option>
                                        @endif
                                      @endforeach
                                    </select>     
                                  </div>
                              </div>
                              <div class="form-group col-lg-4 md-4 sm-4">
                                  <div class="col-lg-12">
                                    <input type="number"   id="cProducto"  value="1" min="1" class="form-control form-control-radius" >
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
    cantidadAlmacen();
} );
</script>
<script type="text/javascript">
  var nextinput = 0;
  function AgregarCampos(){
    var producto=$('#nProducto').val();
    var cantidad=parseInt($('#cProducto').val());
    var cantidadMax=parseInt($('#cProducto').prop('max'));
    if( cantidad>cantidadMax){
      cantidad=cantidadMax;
    }
       nextinput++;
       campo = '<div id="campo'+nextinput+'"><div class="form-group col-lg-8 md-8 sm-8"><label  class="col-lg-4 control-label form-label">Producto '+(nextinput)+':</label><div class="col-lg-8"><input type="text" id="producto'+nextinput+'" name="producto'+nextinput+'" value="'+producto.substring(producto.indexOf('-')+1)+'" class="form-control form-control-radius" disabled > <input type="hidden" name="producto'+nextinput+'" value="'+producto.substring(0,producto.indexOf('-'))+'"></div></div><div class="form-group col-lg-4 md-4 sm-4"><div class="col-lg-12"><input type="number" value="'+cantidad+'" min="1" max="'+cantidadMax+'" name="cantidad'+nextinput+'" min="1" class="form-control form-control-radius" required ></div></div><div class="form-group col-lg-2 md-2 sm-2"></div>  </div>';
    
   
     
    if(producto!=null){
        $('#totalProductos').val(nextinput);
        $("#nProducto option[value='"+producto+"']").remove();
        $("#bodyModal").prepend(campo);
        $('#cProducto').val();
        $('#nProducto').val();
        cantidadAlmacen();
    }
    else{
      $('#agregar').attr("disabled", true);
    }
 

  }
  function eliminarCampos(campo){
    for (var i = 1; i <= nextinput; i++) {
       var producto=$('#producto'+i);
      $('#nProducto').append($('<option>', {
      value: producto.val(),
      text: producto.val()
      }));
      $('#campo'+i).remove();
    }
    nextinput=0;
    
  }
  function cantidadAlmacen() {

    var producto=$("#nProducto").val();
      $.ajax({
        type: "GET",
        url:'cantidadAlmacen/'+producto.substring(0,producto.indexOf('-')),
        success: llegada,
      });
    function llegada(data){
     
      $("#cProducto").attr('max',data);
       $("#cProducto").val(1);
    }
 }

  function agregarComentario(id) {
    var comentarios=$("#comentarios").val();
      $.ajax({
        type: "GET",
        url:'agregarComentarioPedido/'+id+'?comentarios='+comentarios,
      });
 }
 function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});
}
</script>

@stop
