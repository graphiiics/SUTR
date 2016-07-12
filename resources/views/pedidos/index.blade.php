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
Productos <i class="fa fa-home"></i>
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
          <div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong> {{ Session::get('message')}} </strong>
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                      <tr>
                        <td>{{$pedido->id}}</td>
                        <td>{{$pedido->user->name}}</td>
                        <td>{{$pedido->unidad->nombre}}</td>
                        <td>{{$pedido->fecha}}</td>
                        @if($pedido->estatus==1)
                          <td>Pendiente</td>
                        @elseif($pedido->estatus==2)
                          <td>Realizado</td>
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
                                         <table id="example0" class="table display">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Id</th>
                                                    <th>Nombre</th>
                                                    <th>precio</th>
                                                    <th>Categoría</th>                            </tr>
                                            </thead>
                                            <tbody id="modalTableBody">
                                                @foreach ($pedido->productos as $num =>$producto)
                                                  <tr>
                                                    <td>{{$num+1}}</td>
                                                    <td>{{$producto->id}}</td>
                                                    <td>{{$producto->nombre}}</td>
                                                    <td>${{$producto->precio}}</td>
                                                    <td>{{$producto->categoria}}</td>
                                                </tr>
                                              @endforeach
                                            </tbody>
                                        </table>                  
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                        @if($pedido->estatus==1 && $pedido->user->user_id==Auth::user()->id)
                                         <button type="button" class="btn btn-primary">editar</button>
                                        <button type="button" class="btn btn-danger">Eliminar</button>
                                        @endif
                                        <button type="button" class="btn btn-default">Imprimir</button>
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
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedido') }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                                                                        
                                            <div id="bodyModal" class="form-group">
                                              <label class="col-sm-2 control-label form-label">Unidad: </label>
                                              <div class="col-sm-10">
                                                <select name="categoria" class="selectpicker form-control form-control-radius">
                                                    <option>Real de Minas</option>
                                                    <option>San Agustin</option>
                                                    <option>Rio Grande</option>
                                                    <option>Jerez</option>
                                                    <option>Medica Norte</option>
                                                    <option>Tlatenango</option>
                                                  </select>                  
                                              </div>
                                            </div>

                                            <div class="form-group col-lg-8 md-8 sm-8">
                                                <label " class="col-lg-4 control-label form-label">Producto:</label>
                                                <div class="col-lg-8">
                                                  <select id="nProducto" class="selectpicker form-control form-control-radius">
                                                    @foreach($productos as $producto)
                                                    <option>{{$producto->nombre}}</option>
                                                    @endforeach
                                                  </select>     
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-4 md-4 sm-4">
                                                <div class="col-lg-12">
                                                  <input type="number" id="cProducto"  value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                           <a  href="#" onclick="AgregarCampos();" type="button" class="btn btn-rounded btn-danger btn-icon"><i class="fa fa-plus"></i></a>
                                           
                                        </div>
                                        <div class="modal-footer">
                                          
                                          <button type="submit" class="btn btn-default">Guardar</button>
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
</script>
<script type="text/javascript">
  var nextinput = 0;
  function AgregarCampos(){
var producto=$('#nProducto').val();
 var cantidad=$('#cProducto').val();
  nextinput++;
  campo = '<div class="form-group col-lg-8 md-8 sm-8"><label " class="col-lg-4 control-label form-label">Producto:</label><div class="col-lg-8"><input type="text" id="producto'+nextinput+'" value="'+producto+'" class="form-control form-control-radius"></div></div><div class="form-group col-lg-4 md-4 sm-4"><div class="col-lg-12"><input type="number" value="'+cantidad+'" id="cantidad'+nextinput+'"  class="form-control form-control-radius" ></div></div>';

  $("#bodyModal").append(campo);
  $('#cProducto').val(0);
  $('#nProducto').val();
}
</script>

@stop