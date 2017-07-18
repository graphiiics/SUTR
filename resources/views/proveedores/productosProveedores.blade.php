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
@section('titulo') Precios de Productos
@endsection
@section('tituloModulo')
Productos <i class="fa fa-home"></i>
@endsection
@section ('botones')
<a href="{{route('proveedores')}}" class="btn btn-light"><i class="fa fa-dollar"></i>Mostrar proveedores</a>

<a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
<a href="#" data-toggle="modal" data-target="#modal_imprimir"  class="btn btn-light"><i class="fa fa-print"></i> Imprimir</a>
@endsection
@section('panelBotones')
<li class="checkbox checkbox-primary">
    <a href="{{route('proveedores')}}" class="btn btn-light cerrarPanel"><i class="fa fa-dollar"></i>Mostrar proveedores</a>
  </li>
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i> Crear Nuevo</a>
  </li>
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_imprimir"  class="btn btn-light cerrarPanel"><i class="fa fa-print"></i> Imprimir</a>
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
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>última compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($proveedores as $proveedor )
                       @foreach($proveedor->productos as $producto)
                        <tr>
                          <td></td>
                          <td>{{$producto->nombre}} ({{$producto->categoria}})</td>
                          <td>${{$producto->pivot->precio}}</td>
                          <td>{{$proveedor->nombre}}</td>
                          <td>{{$proveedor->telefono}}</td>
                          <td>{{$producto->pivot->updated_at}}</td>
                          <td><a  href="#" data-toggle="modal" data-target="#modal{{$producto->id}}-{{$proveedor->id}}" class="btn btn-rounded btn-light">Editar</a>
                            <!-- Modal -->
                                <div class="modal fade" id="modal{{$producto->id}}-{{$proveedor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar </h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarProductoProveedor') }}">
                                        {!! csrf_field() !!}
                                        <div class="modal-body">
                                            <div class="form-group col-lg-12 md-12 sm-812">
                                                <label class="col-lg-2 control-label form-label">Proveedores:</label>
                                                <div class="col-lg-10">
                                                  <select  name="proveedor"  class="form-control ">

                                                      {{-- Solicita cantidad al almacen --}}
                                                        <option value="{{$proveedor->id}}" >{{$proveedor->nombre}}</option>

                                                  </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="productoActual" value="{{$producto->id}}">
                                            <div class="form-group col-lg-12 md-812 sm-12">
                                                <label class="col-lg-2 control-label form-label productoClass">Producto:</label>
                                                <div class="col-lg-10">
                                                  <select  name="producto"  class="form-control ">
                                                    @foreach($productos as $producto)
                                                       {{-- Solicita cantidad al almacen --}}
                                                        <option value="{{$producto->id}}" >{{$producto->nombre}}</option>

                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                              <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Precio: </label>
                                              <div class="col-sm-10">
                                                <input type="number" name="precio" placeholder="Empresa" step="0.01" min="0" value="0" class="form-control " >
                                              </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-sm-4 control-label form-label">Eliminar:</label>
                                            <div class="col-sm-8">
                                              <input type="checkbox" name="eliminar" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          <button type="submit"  class="btn btn-default" >Guardar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              <!-- End Modal Code -->
                              </td>
                      </tr>
                      @endforeach
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
                  <h4 class="modal-title">Nueva relación producto-proveedor</h4>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarProductoProveedor') }}">
                  {!! csrf_field() !!}
                  <div class="modal-body">

                      <div class="form-group col-lg-12 md-12 sm-812">
                          <label class="col-lg-2 control-label form-label">Proveedores:</label>
                          <div class="col-lg-10">
                            <select id="NuevoProveedor" name="proveedor" onchange="productosDisponibles();" class="form-control ">
                              @foreach($proveedores as $proveedor)
                                {{-- Solicita cantidad al almacen --}}
                                  <option value="{{$proveedor->id}}" >{{$proveedor->nombre}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="form-group col-lg-12 md-812 sm-12">
                          <label class="col-lg-2 control-label form-label">Producto:</label>
                          <div class="col-lg-10">
                            <select id="NuevoProducto" name="producto"  class="form-control ">

                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label form-label">Precio: </label>
                          <div class="col-sm-10">
                            <input type="number" name="precio" placeholder="Empresa" step="0.01" min="0" value="0" class="form-control " >
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

        <!-- Modal -->
          <div class="modal fade" id="modal_imprimir" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Selecciona los proveedores a comparar</h4>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('precioProveedoresPdf') }}">
                  {!! csrf_field() !!}
                  <div class="modal-body">

                      <div class="form-group col-lg-12 md-12 sm-812">
                          <label class="col-lg-2 control-label form-label">Proveedores:</label>
                          <div class="col-lg-9">
                            <select id="proveedorImprimir" name="proveedor"  class="form-control ">
                              @foreach($proveedores as $proveedor)
                                {{-- Solicita cantidad al almacen --}}
                                  <option value="{{$proveedor->id}}-{{$proveedor->nombre}}" >{{$proveedor->nombre}}</option>
                              @endforeach
                            </select>
                          </div>

                          <button type="button" onclick="agregarProveedor();" class="btn btn-rounded btn-success btn-icon"><i class="fa fa-plus"></i></button>
                      </div>
                  </div>
                  <div id="imprimirProveedores" class="form-group">
                    <input type="hidden" id="totalProveedores" name="totalProveedores" >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-default"   onclick="enviar();">Imprimir</button>
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
var contadorProveedor=0;
$(document).ready(function() {
    $('#example0').DataTable();
} );
 productosDisponibles();
function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});

}

function productosDisponibles(){
  $('#NuevoProducto').empty();
  var proveedor=$("#NuevoProveedor").val();
    $.ajax({
      type: "GET",
      url:'productosDisponibles/'+proveedor,
      success: llegada,
    });
  function llegada(data){

    $.each(data, function(i,p) {
            $('#NuevoProducto').append($('<option>', {
            value: p.id,
            text: p.nombre
             }));
          //console.log(p.pivot.precio);
        });
  }
}

function agregarProveedor(){
  contadorProveedor++;
  var proveedor=$('#proveedorImprimir').val();
  $('#totalProveedores').val(contadorProveedor);
  var input=' <div class="col-lg-10 col-lg-offset-1"><input type="text" class="form-control " readonly value="'+proveedor+'"><div><input type="hidden" name="proveedor'+contadorProveedor+'" value="'+proveedor.substring(0,proveedor.indexOf('-'))+'" >';
  $('#imprimirProveedores').append(input);
  $("#proveedorImprimir option[value='"+proveedor+"']").remove();
}

</script>

@stop
