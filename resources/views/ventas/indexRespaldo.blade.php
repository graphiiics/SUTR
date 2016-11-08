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
@section('titulo') Ventas 
@endsection
@section('tituloModulo')
Ventas <i class="fa fa-home"></i>
@endsection
@section ('botones')
  
  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i>Nueva venta</a>
  @if(Auth::user()->tipo==3)
    <a href="#" data-toggle="modal" data-target="#modal"  class="btn btn-light"><i class="fa fa-money"></i>Corte de caja</a>
    <a href="{{route('cortesGerente')}}"  class="btn btn-light"><i class="fa fa-archive"></i>Mostrar cortes realizados</a>
  @elseif(Auth::user()->tipo<3)
     <a href="{{route('cortes')}}"  class="btn btn-light"><i class="fa fa-archive"></i>Mostrar cortes realizados</a>
     <a href="#" data-toggle="modal" data-target="#modalActual"  class="btn btn-light"><i class="fa fa-money"></i>Ventas Actuales</a>
  @endif
 
@endsection
@section('panelBotones')
    <li class="checkbox checkbox-primary">
   <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i>Nueva venta</a>
     </li>
  @if(Auth::user()->tipo==3)
     <li class="checkbox checkbox-primary">
      <a href="#" data-toggle="modal" data-target="#modal"  class="btn btn-light cerrarPanel"><i class="fa fa-money"></i>Corte de caja</a>
    </li>
    <li class="checkbox checkbox-primary">
      <a href="{{route('cortesGerente')}}"  class="btn btn-light"><i class="fa fa-archive cerrarPanel"></i>Mostrar cortes realizados</a>
    </li>
  @elseif(Auth::user()->tipo<3)
   <li class="checkbox checkbox-primary">
     <a href="{{route('cortes')}}"  class="btn btn-light"><i class="fa fa-archive cerrarPanel"></i>Mostrar cortes realizados</a>
    </li>
    <li class="checkbox checkbox-primary">
     <a href="#" data-toggle="modal" data-target="#modalActual"  class="btn btn-light cerrarPanel"><i class="fa fa-money"></i>Ventas Actuales</a>
    </li>
  @endif

  
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
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Importe</th>
                <th>Pago</th>
                <th>Estado</th>
                <th>Comentario</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ventas as $venta)
                @if($venta->estatus==1)
                  <tr>
                @elseif($venta->estatus==2)
                  <tr class="danger">
                @endif
                  <td>{{$venta->id}}</td>
                  <td>{{$venta->user->name}}</td>
                  <td>{{$venta->fecha}}</td>
                  <td>{{$venta->cliente}}</td>
                  <td>${{$venta->importe}}.00</td>
                  @if($venta->pago==1)
                    <td>Efectivo</td>
                  @elseif($venta->pago==2)
                    <td>Credito</td>
                  @endif
                   @if($venta->estatus==1)
                    <td>Liquidado</td>
                  @elseif($venta->estatus==2)
                    <td>Pendiente</td>
                  @endif
                  @if($venta->comentarios==null)
                    <td >Ningún comentario</td>
                  @else
                    <td><i title="{{$venta->comentarios}}">Mensaje</i</td>
                  @endif
                  <td><a  href="#" data-toggle="modal" data-target="#modal{{$venta->id}}" class="btn btn-rounded btn-light">Ver detalles</a>
                      <!-- Modal -->
                        <div class="modal fade" id="modal{{$venta->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detalles de la venta {{$venta->id}} de {{$venta->cliente}}</h4>
                              </div>
                              <div class="modal-body">
                                 <table class="table-striped " width="100%">
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
                                        @foreach ($venta->productos as $num =>$producto)
                                          <tr>
                                            <td>{{$num+1}}</td>
                                            <td>{{$producto->id}}</td>
                                            <td>{{$producto->nombre}}</td>
                                            <td>${{$producto->pivot->precio}}</td>
                                             @if($producto->pivot->cantidad==1)
                                               <td>{{$producto->pivot->cantidad}} {{$producto->presentacion}}</td>
                                            @else
                                               <td>{{$producto->pivot->cantidad}} {{$producto->presentacion}}s</td>
                                            @endif
                                            <td>{{$producto->categoria}}</td>
                                         </tr>
                                      @endforeach
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td>${{$venta->importe}}</td>
                                        <td></td>
                                        <td></td>
                                      </tr>
                                    </tbody>
                                </table>                  
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                @if(Auth::user()->id==$venta->user_id && $venta->estatus==2)
                                  @if(Auth::user()->tipo==1)
                                    <a href="{{ route('liquidarVenta',$venta->id) }}" type="button" class="btn btn-danger">Liquidar</a>
                                  @elseif(Auth::user()->tipo==2)
                                    <a href="{{ route('liquidarVenta',$venta->id) }}" type="button" class="btn btn-danger">Liquidar</a>
                                  @elseif(Auth::user()->tipo==3)
                                    <a href="{{ route('liquidarVentaGerente',$venta->id) }}" type="button" class="btn btn-danger">Liquidar</a>
                                 @endif
                                @endif
                                
                                <a  href="{{ route('ventaPdf',$venta->id) }}" target="_blank" type="button" class="btn btn-default">Imprimir</a>
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
                 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Corte caja</h4>
                      </div>
                      <div  class="modal-body">    
                        <table class="table-striped"  WIDTH="100%">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Monto</th>
                                <th>Fecha</th>                          
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                  @if(!$venta->corte && $venta->estatus==1)
                                    <tr>
                                      <td>{{$venta->id}}</td>
                                      <td>{{$venta->cliente}}</td>
                                      <td>${{$venta->importe}}</td>
                                      <td>{{$venta->fecha}}</td>
                                   </tr>
                                   @endif
                                @endforeach
                                <tr>
                                  <td></td>
                                  <td>Total</td>
                                  <td>${{$totalCorte}}</td>
                                  <td></td>                                
                                </tr>
                            </tbody>
                        </table>       
                      </div>      
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                          <a href="{{route('realizarCorteGerente')}}" class="btn btn-default" onclick="enviar();">Raalizar Corte</a>
                        </div>
                    </div>
                  </div>
                </div>

      <!-- End Modal Code -->
       <!-- Modal -->
                 <div class="modal fade" id="modalActual" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Totales de cada unidad</h4>
                      </div>
                      <div  class="modal-body">    
                        <table class="table-striped"  WIDTH="100%">
                            <thead>
                              <tr>
                               
                                <th>Nombre</th>
                                <th>Monto en Efectivo</th>  
                                <th>Monto Pendiente</th>                     
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                      
                                      <td>{{$usuario->name}}</td>
                                      <td>${{$usuario->totalVentas}}</td>
                                      <td>${{$usuario->totalPendientes}}</td>
                                   </tr>
                                @endforeach
                                <tr>
                                  <td>Total</td>
                                  <td>${{$totalCorte}}</td> 
                                  <td>${{$totalAdeudo}}</td>                         
                                </tr>
                            </tbody>
                        </table>       
                      </div>      
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                           <a href="{{route('ventasTotalesCortePdf')}}" class="btn btn-default" target="_blank" ">Imprimir</a>
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
                        <h4 class="modal-title">Nueva venta</h4>
                      </div>
                      @if(Auth::user()->tipo==1)
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarVenta') }}">
                      @elseif(Auth::user()->tipo==2)
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarVenta') }}">
                      @elseif(Auth::user()->tipo==3)
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarVentaGerente') }}">
                      @endif
                        {!! csrf_field() !!}  
                        <div  class="modal-body">                                          
                          <div  class="form-group">
                            <label class="col-sm-2 control-label form-label">Tipo: </label>
                            <div class="col-sm-10">
                              <select name="pago" class="selectpicker form-control form-control-radius">
                                  <option value="1">Efectivo</option>
                                  <option value="2">Credito</option>
                              </select>                  
                            </div>
                          </div>
                          <div class="form-group ">
                              <label  class="col-lg-2 control-label form-label">Cliente:</label>
                              <div class="col-lg-10">
                                <input type="text"  name="cliente"  placeholder="Nombre Completo"  class="form-control form-control-radius" required>
                              </div>
                          </div>
                          <div class="form-group  ">
                              <label  class="col-lg-2 md-2 control-label form-label">Producto:</label>
                              <div class="col-lg-8 md-8">
                                <select id="nProducto" v-model="nuevo_producto.nombre" onchange="actualizarPrecio();" class="selectpicker form-control form-control-radius">
                                  @foreach($productos as $producto)
                                    @if($producto->unidades()->find(Auth::user()->unidad_id)->pivot->cantidad>0)
                                    <option value="{{$producto->id}}-{{$producto->nombre}}${{$producto->precio_venta}}" >{{$producto->nombre}}</option>
                                    @endif
                                  @endforeach
                                </select>     
                              </div>
                              <div class="col-lg-2 md-2">
                                 <a  href="#" id="agregar" {{-- onclick="AgregarCampos();"  --}} v-on:click="agregarProducto" class="btn btn-rounded btn-success btn-icon"><i class="fa fa-plus"></i></a>
                              </div>
                          </div>
                          
                          <div class="form-group  ">
                            <div class="col-lg-6 md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">Cantidad</div>
                                      <input type="number" v-model="nuevo_producto.cantidad"  id="cProducto" value="1" min="1"  class="form-control form-control-radius" >
                                   
                                  </div>
                            </div>
                            <div class="col-lg-6 md-6">

                                 <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                     <input type="number"  v-model="nuevo_producto.precio" id="precio" min="0" value="0" step=".01" class="form-control form-control-radius" >
                                  </div>
                            </div>
                          </div>
                          <div class="form-group " >
                              <div>
                                <table class="table-striped " width="100%">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Nombre</th> 
                                          <th>precio</th>
                                          <th>Cantidad</th>                                         
                                          <th>total</th>                         
                                      </tr>
                                  </thead>
                                  <tbody id="bodyModal">
                                       <tr v-for="producto in productos">
                                          <td>@{{$index+1}}</td>
                                          <td>@{{producto.nombre}}</td>
                                          <td>@{{producto.precio}}</td>
                                          <td>@{{producto.cantidad}}</td>
                                          <td>@{{producto.precio*producto.cantidad}}</td>
                                       </tr>
                                          
                                         
                                      <tr>
                                          <td></td>
                                          <td>Totales</td>
                                          <td ><input type="text" id="tProductos"  class="form-control " readonly ></td>
                                          <td ><input type="text"  id="tPrecio"  class="form-control" readonly ></td>
                                         
                                    </tr>
                                  </tbody>
                              </table> 
                              </div>   
                            <input type="hidden" id="totalProductos" name="totalProductos" value="0">
                            <input type="hidden" id="totalPrecio" name="importe" value="0">
                          </div>
                           <div class="form-group" id="catheter">
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
    actualizarPrecio();
} );

</script>
<script type="text/javascript">
  var nextinput = 0;
  var precioTotal = 0;
  var productosTotal =0;
  function AgregarCampos(){
    var producto=$('#nProducto').val();
    var cantidad=parseInt($('#cProducto').val());
    var cantidadMax=parseInt($('#cProducto').prop('max'));
    var precio=parseFloat($('#precio').val());
     if(producto.substring(0,producto.indexOf('-'))==19){
      campoCatheter='<div class="col-lg-12 md-12"><label  class="col-lg-4 md-4 control-label form-label">Instaldor:</label><div class="col-lg-8 md-8"><input type="text"   id="instalador" name="instalador"  class="form-control form-control-radius" ></div></div>';
       $("#catheter").prepend(campoCatheter);
     }
     if(cantidad>cantidadMax){
        cantidad=cantidadMax;
     }
    if(cantidad>0 && precio>0){
        nextinput++;
        campo = '<tr id="campo'+nextinput+'"><td >'+(nextinput)+'</td><td><input type="text" id="producto'+nextinput+'"  value="'+producto.substring(producto.indexOf('-')+1,producto.indexOf('$'))+'" class="form-control " disabled ><input type="hidden" id="prod'+nextinput+'" name="producto'+nextinput+'" value="'+producto.substring(0,producto.indexOf('-'))+'"><input type="hidden" id="pd'+nextinput+'" value="'+producto.substring(producto.indexOf('$')+1)+'"></td><td ><input type="text" value="'+cantidad+'" name="cantidad'+nextinput+'"  class="form-control  " readonly ></td><td><input type="text" value="'+precio+'" name="precio'+nextinput+'"  class="form-control " readonly ></td></tr>';
        if(producto!=null){
            productosTotal=productosTotal+cantidad;
            precioTotal=Math.round(precioTotal+(precio*cantidad));
            $('#totalProductos').val(nextinput);
            $("#nProducto option[value='"+producto+"']").remove();
            $("#bodyModal").prepend(campo);
            $('#cProducto').val();
            $('#nProducto').val();
            $('#tPrecio').val('$ '+precioTotal+'.00');
            $('#totalPrecio').val(precioTotal);
            $('#tProductos').val(productosTotal);
            var producto=$('#nProducto').val();
             cantidadUnidad();
     $('#precio').val(producto.substring(producto.indexOf('$')+1));
        }
        else{
          $('#agregar').attr("disabled", true);
        }
    }else{
      alert('Debes de ingresar cantidad y precio');
    }
    
    
  }
  function eliminarCampos(campo){
    for (var i = 1; i <= nextinput; i++) {
       var producto=$('#producto'+i);
       var prod=$('#prod'+i);
       var pd=$('#pd'+i);
      $('#nProducto').append($('<option>', {
      value: prod.val()+'-'+producto.val()+'$'+pd.val(),
      text: producto.val()
      }));
      $('#campo'+i).remove();
    }
    $('#tPrecio').val(0);
    $('#tProductos').val(0);
    nextinput=0;
    precioTotal = 0;
    productosTotal =0;
    $("#catheter").empty()
  }
  function actualizarPrecio(){
    cantidadUnidad();
      var producto=$('#nProducto').val();
     $('#precio').val(producto.substring(producto.indexOf('$')+1));

  }
  function cantidadUnidad() {
    var producto=$("#nProducto").val();
      $.ajax({
        type: "GET",
        url:'cantidadUnidad/'+producto.substring(0,producto.indexOf('-')),
        success: llegada,
      });
    function llegada(data){
     
      $("#cProducto").attr('max',data);
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
<script type="text/javascript">
  
var app = new Vue({
  el: '#modal_nuevo',
  data: {
    productos: [{producto_id:0,nombre:"gato",cantidad:8,precio:6},{producto_id:0,nombre:"gato",cantidad:8,precio:6}],
    totalProductos:0,
    totalVenta:0,
    nuevo_producto:{producto_id:0,nombre:"",cantidad:0,precio:0}
  },
  methods: {
    agregarProducto: function (event) {
      this.productos.push(this.nuevo_producto)
      this.nuevo_producto=''
    }
  }
})



</script>

@stop


