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
  
  
  @if(Auth::user()->tipo==3)
    <a href="#" data-toggle="modal" data-target="#modal"  class="btn btn-light"><i class="fa fa-money"></i>Corte de caja</a>
    <a href="{{route('cortesGerente')}}"  class="btn btn-light"><i class="fa fa-archive"></i>Mostrar cortes realizados</a>
  @elseif(Auth::user()->tipo<3)
     <a href="{{route('cortes')}}"  class="btn btn-light"><i class="fa fa-archive"></i>Mostrar cortes realizados</a>
     <a href="#" data-toggle="modal" data-target="#modalActual"  class="btn btn-light"><i class="fa fa-money"></i>Ventas Actuales</a>
     <a href="#" data-toggle="modal" data-target="#modelFechas"  class="btn btn-light"><i class="fa fa-file-pdf-o"></i>Reporte de Ventas</a>
  @endif
 <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i>Nueva venta</a>
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
                                        <th>total</th>                            
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
                                            <td>${{ceil($producto->pivot->cantidad*$producto->pivot->precio)}}</td>
                                         </tr>
                                      @endforeach
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2">Total</td>
                                        <td>${{$venta->importe}}</td>
                                      </tr>
                                    </tbody>
                                </table>                  
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                @if(Auth::user()->id==$venta->user_id && $venta->estatus==2)
                                  @if(Auth::user()->tipo==1)
                                    <a href="{{ route('liquidarVenta',$venta->id) }}" type="button" class="btn btn-wargning">Liquidar</a>
                                  @elseif(Auth::user()->tipo==2)
                                    <a href="{{ route('liquidarVenta',$venta->id) }}" type="button" class="btn btn-wargning">Liquidar</a>
                                  @elseif(Auth::user()->tipo==3)
                                    <a href="{{ route('liquidarVentaGerente',$venta->id) }}" type="button" class="btn btn-wargning">Liquidar</a>
                                 @endif
                                @endif
                                @if(Auth::user()->tipo<3)
                                  <a href="{{ route('eliminarVenta',$venta->id) }}" type="button" class="btn btn-danger">Eliminar</a>
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
             <div class="modal fade" id="modelFechas" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reporte de Ventas Totales </h4>
                  </div>
                   <form class="form-horizontal" role="form" method="POST" action="{{ route('reporteVentasPdf') }}">
                  {!! csrf_field() !!}  
                  <div  class="modal-body">   
                    <div class="form-group">
                      <h5>Rengo de fechas del reporte</h5>
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
                      <label class="col-sm-2 control-label form-label">Unidad: </label>
                      <div class="col-sm-10">

                        <select name="unidad" v-model="pago" class="selectpicker form-control form-control-radius" >
                              <option value="0">Todas</option>
                            @foreach($usuarios as $usuario)
                              <option value="{{$usuario->id}}">{{$usuario->unidad->nombre}}</option>
                            @endforeach
                        </select>                  
                      </div>
                    </div>
                  </div>      
                
                    <div class="modal-footer">
                      <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                       <button type="submit" class="btn btn-default" >Imprimir</button>
                    </div>
                </div>
                </form>
              </div>
            </div>

      <!-- End Modal Code -->
       <!-- Modal -->
                 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Corte caja</h4>
                      </div>
                      <div  class="modal-body">    
                        <table class="table-striped"  width="100%">
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
                              <select name="pago" v-model="pago" class="selectpicker form-control" >
                                  <option value="1">Efectivo</option>
                                  <option value="2">Credito</option>
                              </select>                  
                            </div>
                          </div>
                          <div class="form-group ">
                              <label  class="col-lg-2 control-label form-label">Cliente:</label>
                              <div class="col-lg-10">
                                <input type="text"  name="cliente" v-model="cliente" placeholder="Nombre Completo"  class="form-control form-control-radius" required>
                              </div>
                          </div>
                          <div class="form-group  ">
                              <label  class="col-lg-2 md-2 control-label form-label">Producto:</label>
                              <div class="col-lg-8 md-8">
                                <select  v-model="producto"  id="producto" class="form-control form-control-radius"  @change="datosProducto(producto)">
                                    <option value="" >Selecciona un suplemento</option>
                                    <option v-for="suplemento in suplementos" value="@{{suplemento.key}}">
                                      @{{suplemento.nombre}} (@{{suplemento.presentacion}})
                                    </option>
                                </select>     
                              </div>
                              <div class="col-lg-2 md-2">
                                 <a  href="#" id="agregar" v-on:click="agregarProducto(producto)"  v-on:keyup.enter="agregarProducto(producto)"  class="btn btn-rounded btn-success btn-icon"><i class="fa fa-plus"></i></a>
                              </div>
                          </div>
                          
                          <div class="form-group  ">
                            <div class="col-lg-6 md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">Cantidad</div>
                                      <input type="number" v-model="cantidad"  value="1" min="1" :max="cantidadMaxima" class="form-control form-control-radius" >
                                   
                                  </div>
                            </div>
                            <div class="col-lg-6 md-6">

                                 <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                     <input type="number"  v-model="precio" min="0" value="0" step=".01" class="form-control form-control-radius" >
                                  </div>
                            </div>
                          </div>
                          <div class="form-group " >
                              <div>
                                <table class="table-striped" width="100%">
                                  <thead>
                                      <tr>
                                          <th width="5%">#</th>
                                          <th width="40%">Producto </th> 
                                          <th width="10%">Precio</th>
                                          <th width="15%">Cantidad</th>                                         
                                          <th width="15%">Total</th>      
                                          <th width="15%">Acciones</th>                   
                                      </tr>
                                  </thead>
                                  <tbody id="bodyModal">
                                       <tr v-for="producto in productos">
                                         <template v-if="!producto.editando">
                                            <td>@{{$index+1}}</td>
                                            <td>@{{producto.nombre}}<input type="hidden" :name="'producto'+($index+1)" :value="producto.id_producto"></td>
                                            <td><input type="hidden" :name="'precio'+($index+1)" class="form-control" :value="producto.precio">@{{producto.precio}}</td>
                                            <td><input type="hidden" :name="'cantidad'+($index+1)"  class="form-control" :value="producto.cantidad">@{{producto.cantidad}}</td>
                                            <td>@{{Math.round(producto.precio*producto.cantidad)}}</td>
                                            <td><a  @click="editarProducto(producto)" class="btn btn-default btn-rounded btn-icon"><i class="fa fa-pencil"></i></a>
                                            <a  @click="eliminarProducto(producto)" class="btn btn-danger btn-rounded btn-icon"><i class="fa fa-close"></i></a></td>
                                         </template>
                                         <template v-if="producto.editando">
                                            <td>@{{$index+1}}</td>
                                            <td>@{{producto.nombre}}</td>
                                            <td>@{{producto.precio}}</td>
                                            <td><input v-model="producto.cantidad" type="number" min="1"  class="form-control"></td>
                                            <td>@{{producto.precio*producto.cantidad}}</td>
                                            <td><a  @click="actualizarProducto(producto)" class="btn btn-success btn-rounded btn-icon"><i class="fa fa-check"></i></a></td>
                                         </template>
                                       </tr> 
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td>Totales</td>
                                          <td >@{{totalProductos}} piezas<input type="hidden" name="totalProductos" class="form-control" :value="productos.length"></td>
                                          <td rowspan="2" >$@{{totalVenta}}<input type="hidden" name="importe" class="form-control" :value="totalVenta"></td>
                                         
                                    </tr>
                                  </tbody>
                              </table> 
                              </div>   
                           
                         
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-success" v-if="!enviando"  @click="enviarVenta">Guardar</button>
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
    $('#date-range-picker').daterangepicker(null, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
   
} );

</script>


<script type="text/javascript">
  
var app = new Vue({
  
  el: '#modal_nuevo',
  data: { 
    enviando:false,
    id:0,
    producto:"",
    nombre:"",
    cantidad: 0,
    precio:0,
    id_producto:0,
    productos: [],
    totalProductos:0,
    totalVenta:0,
    suplementos:[],
    cliente:'',
    pago:1,
    cantidadMaxima:0,
  },
  methods: {
    agregarProducto: function (producto) {
      if(this.nombre!=""){
        this.productos.push({id:this.id,id_producto:this.id_producto,nombre:this.nombre,precio:this.precio,cantidad:this.cantidad,editando:false})
        $("#producto option[value='"+producto+"']").remove();
        this.nombre=""
        this.totalProductos+=parseInt(this.cantidad)
        this.totalVenta+=Math.round(this.cantidad*this.precio);
      }
      
    },
    obtenerProductos: function(){
      //console.log("hola")
     this.$http.get('../productosVenta').then((response) => {
         this.$set('suplementos',response.body)
         console.log(this.suplementos)  
        });
    },
    datosProducto: function(index) {
      this.nombre= this.suplementos[index].nombre+' ('+this.suplementos[index].presentacion+')';
      this.cantidad=1
      this.precio=this.suplementos[index].precio_venta
      this.id=index
      this.id_producto=this.suplementos[index].id
      this.cantidadMaxima=this.suplementos[index].stock
    },
      
    eliminarProducto:function(producto){
      $('#producto').append($('<option>', {
      value: producto.id,
      text: producto.nombre
      }));
      this.productos.$remove(producto)
      this.totalProductos-=parseInt(producto.cantidad)
      this.totalVenta-=Math.round(producto.cantidad*producto.precio);


    },
    editarProducto: function(producto){
      this.totalProductos-=parseInt(producto.cantidad)
      this.totalVenta-=Math.round(producto.cantidad*producto.precio);
      producto.editando=true;
    },
    actualizarProducto: function(producto){
      producto.editando=false;
      this.totalProductos+=parseInt(producto.cantidad)
      this.totalVenta+=Math.round(producto.cantidad*producto.precio);
    },
    enviarVenta: function(){
      if(this.producto.length>0 && this.cliente.length>1)
        this.enviando=true
      
    }

  },
  ready: function(){
      this.obtenerProductos();
     
  }
})



</script>

@stop


