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
    
      <a href="#" data-toggle="modal" data-target="#modalIngresoEgreso"  class="btn btn-light"><i class="fa fa-calculator"></i>Ingresos/Egresos</a>
    
    <a href="{{route('cortesGerente')}}"  class="btn btn-light"><i class="fa fa-archive"></i>Mostrar cortes realizados</a>
  @elseif(Auth::user()->tipo<3)
     <a href="{{route('cortes')}}"  class="btn btn-light"><i class="fa fa-archive"></i>Mostrar cortes realizados</a>
     <a href="#" data-toggle="modal" data-target="#modalActual"  class="btn btn-light"><i class="fa fa-money"></i>Ventas Actuales</a>
     <a href="#" data-toggle="modal" data-target="#modelFechas"  class="btn btn-light"><i class="fa fa-file-pdf-o"></i>Reporte de Ventas</a>
     <a href="#" data-toggle="modal" data-target="#modalEnvios"  class="btn btn-light"><i class="fa fa-file-text"></i>Registro de Suplementos</a>
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
      <a href="#" data-toggle="modal" data-target="#modalIngresoEgreso"  class="btn btn-light cerrarPanel"><i class="fa fa-money"></i>Ingresos/Egresos</a>
    </li>
    <li class="checkbox checkbox-primary">
      <a href="{{route('cortesGerente')}}"  class="btn btn-light"><i class="fa fa-archive cerrarPanel"></i>Mostrar cortes realizados</a>
    </li>
  @elseif(Auth::user()->tipo<3)
   <li class="checkbox checkbox-primary">
     <a href="{{route('cortes')}}"  class="btn btn-light"><i class="fa fa-archive cerrarPanel"></i>Mostrar cortes realizados</a>
    </li>
    <li class="checkbox checkbox-primary">
      <a href="#" data-toggle="modal" data-target="#modalEnvios"  class="btn btn-light cerrarPanel"><i class="fa fa-file-text "></i>Registro de Suplementos</a>
    </li>
    <li class="checkbox checkbox-primary">
     <a href="#" data-toggle="modal" data-target="#modalActual"  class="btn btn-light cerrarPanel"><i class="fa fa-money"></i>Ventas Actuales</a>
    </li>
  @endif

  
@endsection
 @section('contenido')
        <!-- Start Panel -->
  <div class="row">

    <div class="col-md-12 col-lg-12">
      @if(Session::has('message'))
        <div  class="alert alert-{{ Session::get('class') }} alert-dismissable kode-alert-click">
          <strong>{{ Session::get('message')}} </strong>
        </div>
      @endif
      <div class="panel panel-default">
        <div class="panel-title">
         
        </div>
        <div class="panel-body table-responsive"  id="tablaVentas" >
        
         <div class=" col-lg-3 col-sm-6  col-lg-offset-9">
            <div class="input-group">
              <input type="search" v-model="buscar" @click="VentasBusqueda()" name="buscar" class="form-control" placeholder="Buscar">
              <span v-if="buscar.length>0" class="input-group-addon" @click="fetchItems(1)" >x</span>
            </div>
          </div>
          <input type="hidden" v-model="empleado" value="{{Auth::user()->id}}">
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
               <tr v-for="venta in ventas |filterBy buscar" :class="{danger: venta.estatus==2}" >
                
                  <td>@{{venta.id}}</td>
                  <td>@{{venta.user.name}}</td>
                  <td>@{{venta.fecha}}</td>
                  <td>@{{venta.cliente}}</td>
                  <td>$@{{venta.importe}}</td>
                  <template v-if="venta.pago== 1">
                    <td>Efectivo</td>
                  </template>
                  <template v-else>
                    <td>Credito</td>
                  </template>
                  <template v-if="venta.estatus == 1">
                    <td>Liquidada</td>
                  </template>
                  <template v-else>
                    <td>Pendiente</td>
                  </template>
                  <template v-if="venta.observaciones.length<1">
                    <td>Ningún comentario</td>
                  </template>
                  <template v-else>
                       <td>@{{venta.observaciones}}</td>
                  </template>
                  
                  <td><a  href="#" data-toggle="modal" data-target="#modal@{{venta.id}}" class="btn btn-rounded btn-light">Ver detalles</a>
                      <!-- Modal -->
                        <div class="modal fade" id="modal@{{venta.id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detalles de la venta @{{venta.id}} de @{{venta.cliente}}</h4>
                              </div>
                              <div class="modal-body">
                                 <table class="table-striped" width="100%">
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
                                    <tbody  class="table-striped">
                                        
                                          <tr v-for="producto in venta.productos">
                                            <td>@{{$index+1}}</td>
                                            <td>@{{producto.id}}</td>
                                            <td>@{{producto.nombre}}</td>
                                            <td>$@{{producto.pivot.precio}}</td>
                                            <template v-if="producto.pivot.cantidad==1">
                                              <td>@{{producto.pivot.cantidad}} @{{producto.presentacion}}</td>
                                            </template>
                                            <template v-else>
                                              <td>@{{producto.pivot.cantidad}} @{{producto.presentacion}}s</td>
                                            </template>
                                            <td>$@{{Math.round(producto.pivot.cantidad*producto.pivot.precio)}}</td>
                                         </tr>
                                      
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2">Total</td>
                                        <td>$@{{venta.importe}}</td>
                                      </tr>
                                    </tbody>
                                </table>                  
                              </div>
                              <div class="modal-footer">
                                
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                @if(Auth::user()->tipo<3)
                                  <a @click="eliminarVenta(venta.id)" data-dismiss="modal" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Eliminar</a>
                                @endif
                                <template v-if="empleado==venta.user_id">
                                    <template v-if="venta.estatus==2">
                                       <a @click="liquidarVenta(venta.id)" data-dismiss="modal" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Liquidar</a>
                                    </template>
                                     
                                </template>
                                <a  href="../ventaPdf/@{{venta.id}}" target="_blank" type="button" class="btn btn-default">Imprimir</a>
                              </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal Code -->

                  </td>

                  </tr>
              </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li v-if="pagination.current_page > 1">
                        <a href="#" aria-label="Previous"
                           @click.prevent="changePage(pagination.current_page - 1)">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li v-for="page in pagesNumber"
                        v-bind:class="[ page == isActived ? 'active' : '']">
                        <a href="#"
                           @click.prevent="changePage(page)">@{{ page }}</a>
                    </li>
                    <li v-if="pagination.current_page < pagination.last_page">
                        <a href="#" aria-label="Next"
                           @click.prevent="changePage(pagination.current_page + 1)">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
          </div>
        </div>
      </div>
    </div >
    <!-- End Panel -->
    <!-- Modal -->
      <div class="modal fade" id="modalIngresoEgreso" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Ingresos y Egresos de Efectivo</h4>
            </div>
            <div  class="modal-body" id="ingresosEgresos">
              <form class="form-horizontal">
                <div  class="form-group">
                  <label class="col-sm-2 control-label form-label">Tipo: </label>
                  <div class="col-sm-10">
                    <select  v-model="tipo" class="form-control" >
                        <option value="1">Ingreso</option>
                        <option value="2" selected>Egreso</option>
                    </select>                  
                  </div>
                </div>
                <div  class="form-group">
                  <label class="col-sm-2 control-label form-label">Concepto: </label>
                  <div class="col-sm-10">
                    <input type="text"  class="form-control" name="concepto" v-model="concepto">
                  </div>
                </div>
                <div  class="form-group">
                  <label class="col-sm-2 control-label form-label">Importe: </label>
                  <div class="col-sm-6">
                    <input type="number"  class="form-control" name="Importe" min="0" step=".1" v-model="importe">
                  </div>
                   <div class="col-sm-4">
                   <a  href="#" class="btn btn-rounded btn-success btn-icon pull-right" @click="enviarDatos()"><i class="fa fa-plus"></i></a>
                  </div>
                </div>
                <div class="form-group" >
                  <h4 class=" form-label">Ingresos </h4>
                  <table width="100%">
                    <thead>  
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>Acciones</th>
                      </tr>                    
                    </thead>
                    <tbody> 
                      <tr v-for="ingreso in ingresos">
                        <th>@{{$index+1}}</th>
                        <th>@{{ingreso.fecha}}</th>
                        <th>@{{ingreso.concepto}}</th>
                        <th>$@{{ingreso.importe}}</th>
                        <td><a  @click="eliminarIngreso(ingreso)"  title="¡Eliminar!" class="btn btn-danger btn-rounded btn-icon"><i class="fa fa-trash-o"></i></a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>Total:</td>
                        <td>$@{{totalIngresos}}</td>                        
                      </tr>                     
                    </tbody>
                  </table>
                </div>
                <div class="form-group" >
                  <h4 class="form-label">Egresos </h4>
                  <table width="100%">
                    <thead> 
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>Acciones</th>
                      </tr>                      
                    </thead>
                    <tbody>  
                       <tr v-for="egreso in egresos">
                        <th>@{{$index+1}}</th>
                        <th>@{{egreso.fecha}}</th>
                        <th>@{{egreso.concepto}}</th>
                        <th>$@{{egreso.importe}}</th>
                        <td><a  @click="eliminarEgreso(egreso)" title="¡Eliminar!" class="btn btn-danger btn-rounded btn-icon"><i class="fa fa-trash-o"></i></a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>Total: </td>
                        <td>$@{{totalEgresos}}</td>
                      </tr>                     
                    </tbody>
                  </table>
                </div>
                
                
              </form>
            </div>      
            <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- End Modal Code -->
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
         <div class="modal fade" id="modalEnvios" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reporte de Ventas Totales </h4>
              </div>
               <form class="form-horizontal" role="form" method="POST" action="{{ route('reporteVentasPdf') }}">
              {!! csrf_field() !!}  
              <div  class="modal-body">   
                
              </div>      
            
                <div class="modal-footer">
                  
                   <a  class="btn btn-default" >Imprimir</a>
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
                        <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarVenta') }}">
                      @elseif(Auth::user()->tipo==3)
                        <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarVentaGerente') }}">
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
                                <input type="text"  name="cliente" v-model="cliente" placeholder="Nombre Completo"  class="form-control form-control" required>
                              </div>
                          </div>
                          <div class="form-group  ">
                            <label  class="col-lg-2 md-2 control-label form-label">Producto:</label>
                            <div class="col-lg-8 md-8">
                              <select  v-model="producto"  id="producto" class="form-control form-control"  @change="datosProducto(producto)">
                                <option value="" >Selecciona un suplemento</option>
                                <option v-for="suplemento in suplementos" value="@{{suplemento.key}}">
                                  @{{suplemento.nombre}} (@{{suplemento.presentacion}})
                                </option>
                              </select>     
                            </div>
                            <div class="col-lg-2 pull-right">
                              <a  href="#" id="agregar" v-on:click="agregarProducto(producto)"  v-on:keyup.enter="agregarProducto(producto)"  class="btn btn-rounded btn-success btn-icon"><i class="fa fa-plus"></i></a>
                            </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-6 md-6 sm-6">
                                <div class="input-group">
                                  <div class="input-group-addon">Cantidad</div>
                                    <input type="number" v-model="cantidad"  value="1" min="1" :max="cantidadMaxima" class="form-control form-control" >
                                </div>
                              </div>
                              <div class="col-lg-6 md-6 sm-6">
                                <div class="input-group">
                                  <div class="input-group-addon">$</div>
                                    <input type="number"  v-model="precio" min="0" value="0" step=".01" class="form-control form-control" >
                                </div>
                              </div>
                          </div>
                          
                          <div class="form-group" >
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
                          <div class="form-group" v-if="cateter">
                              <div class="form-group ">
                                  <label  class="col-lg-2 control-label form-label">Comentarios:</label>
                                  <div class="col-lg-10">
                                    <input type="text"  name="observaciones" placeholder="Agrega datos del Médico"  class="form-control form-control" required>
                                  </div>
                              </div>
                              
                          </div> 
                        </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" v-if="!enviando"  >Guardar</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

      <!-- End Modal Code -->

 
 @endsection

 @section ('js')

<script type="text/javascript">
  $(document).ready(function() {
    $('#date-range-picker').daterangepicker(null, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
  var suplementos = new Vue({
    
    el: '#header',
    data: { 
     busqueda:""
    },
   
  })
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
    cateter:false,
  },
  methods: {
    agregarProducto: function (producto) {
      if(this.nombre!=""){
          if(this.precio>0){
            if(this.cantidadMaxima<this.cantidad){
              this.cantidad=this.cantidadMaxima;
            }
            if(this.nombre.includes('Cat'))
              this.cateter=true
            this.productos.push({id:this.id,id_producto:this.id_producto,nombre:this.nombre,precio:this.precio,cantidad:this.cantidad,editando:false});
            $("#producto option[value='"+producto+"']").remove();
            this.nombre="";
            this.totalProductos+=parseInt(this.cantidad);
            this.totalVenta+=Math.round(this.cantidad*this.precio);
            this.cantidad=1;
            
          }
          else{
            alert("Te falta agregar precio al producto");
          }
      }
    },
    obtenerProductos: function(){
      //console.log("hola")
     this.$http.get('../productosVenta').then((response) => {
         this.$set('suplementos',response.body)
         //console.log(this.suplementos)  
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
      this.cateter=false;

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

var tabla = new Vue({
        el: '#tablaVentas',
        data: {
            pagination: {
                total: 0,
                per_page: 7,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4,// left and right padding from the pagination <span>,just change it to see effects
            ventas: [],
        buscar:'',
        buscando:false,
        empleado:0,
        },
        ready: function () {
            this.fetchItems(this.pagination.current_page);
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            },


        },
        methods: {
            fetchItems: function (page) {
                var data = {page: page};
                this.$http.get('../obtenerVentas?page='+page,+'&search='+this.buscar).then(function (response) {
                    //look into the routes file and format your response
                    this.$set('ventas', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                    this.buscar='';
                }, function (error) {
                    // handle error
                });
            },
            VentasBusqueda: function () {
                 this.$http.get('../obtenerVentasBusqueda' ).then(function (response) {
                    //look into the routes file and format your response
                    this.$set('ventas', response.body);
                    //console.log(this.ventas);
                  }, function (error) {
                      // handle error
                  });
            },

            changePage: function (page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            },
            liquidarVenta: function(venta){
                swal({
                  title: "¿Estas seguro de liquidar?", 
                  text: "¡Una vez liquidada ya no se podra regresar!", 
                  type: "warning", 
                  showCancelButton: true, 
                  confirmButtonColor: "#DD6B55", 
                  confirmButtonText: "Si, liquidar!", 
                  closeOnConfirm: false 
                },
                function(){
                    tabla.$http.get("liquidarVenta/"+venta).then(function (response) {
                      
                      if(response.body=="liquidado"){
                        swal("Liquidada!", "Proceso realizado correctamente.", "success");
                        tabla.fetchItems(1);
                      }else{
                        swal("Error!", "Error al liquidar la venta", "danger");
                      }
                    
                    }, function (error) {
                      alert('Error al enviar los datos para liquidar');
                    });
                    
                });//funcion Swal
            },
            eliminarVenta: function(venta) {
              swal({
                  title: "¿Estas seguro de Eliminar la venta?", 
                  text: "¡Una vez eliminda ya no se podra regresar!", 
                  type: "warning", 
                  showCancelButton: true, 
                  confirmButtonColor: "#DD6B55", 
                  confirmButtonText: "Si, Eliminar!", 
                  closeOnConfirm: false 
                },
                function(){
                    tabla.$http.get("eliminarVenta/"+venta).then(function (response) {
                      
                      if(response.body=="eliminada"){
                        swal("Eliminda!", "Proceso realizado correctamente.", "success");
                        tabla.fetchItems(1);
                      }else{
                        swal("Error!", "Error al Eliminar la venta", "danger");
                      }
                    
                    }, function (error) {
                      alert('Error al enviar los datos para Eliminar');
                    });
                    

                });//funcion Swal
            }
        }// termina Methods
    });
var io = new Vue({
        el: '#ingresosEgresos',
        data: {
          tipo:1,
          concepto:'',
          importe:0,
          totalIngresos:0,
          totalEgresos:0,
          ingresos:[],
          egresos:[],
        },
        ready: function () {
            this.obtenerIngresos();
            this.obtenerEgresos();
        },
       
        methods: {
            enviarDatos: function (){
              if(this.tipo==1){
                this.$http.get('guardarIngresos?concepto='+this.concepto+'&importe='+this.importe).then(function (response){
                  if(response.body=='exito'){
                    this.obtenerIngresos();
                    this.tipo==2;
                    this.concepto='';
                    this.importe=0;
                  }
                },
                function (error){

                });
              }
              else{
                this.$http.get('guardarEgresos?concepto='+this.concepto+'&importe='+this.importe).then(function (response){
                  if(response.body=='exito'){
                    this.obtenerEgresos();
                    this.tipo==2;
                    this.concepto='';
                    this.importe=0;
                  }
                },
                function (error){

                });  
              }
            },
            obtenerIngresos: function () {
                this.$http.get('obtenerIngresos').then(function (response) {
                    //look into the routes file and format your response
                    this.$set('ingresos', response.body);
                    this.totalIngresos=0;
                    this.totalIngresos=this.totalImporte(this.ingresos);
                    //console.log(this.ingresos)
                }, function (error) {
                    // handle error
                });
            },//
            obtenerEgresos: function () {
                this.$http.get('obtenerEgresos').then(function (response) {
                    //look into the routes file and format your response
                    this.$set('egresos', response.body);
                    this.totalEgresos=0; 
                    this.totalEgresos=this.totalImporte(this.egresos);
                    //console.log(this.egresos)
                }, function (error) {
                    // handle error
                });
            },//termina obtenerEgresos    
            totalImporte: function(data){
              total=0
              for(var i=0;i<data.length;i++){
                  total+=data[i].importe
              }
              console.log(total);   
              return total;
            },
            eliminarIngreso: function(ingreso) {
              swal({
                  title: "¿Estas seguro de eliminar el ingreso de efectivo?", 
                  text: "¡Una vez elimindo ya no volvera :(!", 
                  type: "warning", 
                  showCancelButton: true, 
                  confirmButtonColor: "#DD6B55", 
                  confirmButtonText: "Si, Eliminar!", 
                  closeOnConfirm: false 
                },
                function(){
                    io.$http.get("eliminarIngreso/"+ingreso.id).then(function (response) {
                      
                      if(response.body=="exito"){
                        swal("Eliminda!", "Proceso realizado correctamente.", "success");
                        io.obtenerIngresos();
                      }else{
                        swal("Error!", "Error al eliminar el ingreso", "danger");
                      }
                    
                    }, function (error) {
                      alert('Error al enviar los datos para Eliminar');
                    });
                    

                });//funcion Swal
            },
            eliminarEgreso: function(egreso) {
              swal({
                  title: "¿Estas seguro de eliminar el egreso de efectivo?", 
                  text: "¡Una vez elimindo ya no volvera :(!", 
                  type: "warning", 
                  showCancelButton: true, 
                  confirmButtonColor: "#DD6B55", 
                  confirmButtonText: "Si, Eliminar!", 
                  closeOnConfirm: false 
                },
                function(){
                    io.$http.get("eliminarEgreso/"+egreso.id).then(function (response) {
                      
                      if(response.body=="exito"){
                        swal("Eliminda!", "Proceso realizado correctamente.", "success");
                        io.obtenerEgresos();
                      }else{
                        swal("Error!", "Error al eliminar el egreso", "danger");
                      }
                    
                    }, function (error) {
                      alert('Error al enviar los datos para Eliminar');
                    });
                    

                });//funcion Swal
            }       
        }// termina Methods
    });

</script>

@stop


