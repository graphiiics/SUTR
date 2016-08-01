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
@endsection
@section('panelBotones')
<li class="checkbox checkbox-primary">
    <a href="{{route('proveedores')}}" class="btn btn-light"><i class="fa fa-dollar"></i>Mostrar proveedores</a>
  </li>
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
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>última compra</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($productos as $producto)
                       @foreach($producto->proveedores as $proveedor)
                        <tr>
                          <td>{{$producto->id}}</td>
                          <td>{{$producto->nombre}}</td>
                          <td>${{$proveedor->pivot->precio}}</td>
                          <td>{{$producto->categoria}}</td>
                          <td>{{$proveedor->nombre}}</td>
                          <td>{{$proveedor->telefono}}</td>
                          <td>{{$proveedor->correo}}</td>
                          <td>{{$proveedor->pivot->updated_at}}</td>
                                                  
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
                  <h4 class="modal-title">Nuevo proveedor</h4>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarProductoProveedor') }}">
                  {!! csrf_field() !!}  
                  <div class="modal-body">
                      
                      <div class="form-group col-lg-12 md-12 sm-812">
                          <label " class="col-lg-2 control-label form-label">Proveedores:</label>
                          <div class="col-lg-10">
                            <select id="proveedor" name="proveedor" onchange="cantidadAlmacen();" class="selectpicker form-control form-control-radius">
                              @foreach($proveedores as $proveedor)
                                {{-- Solicita cantidad al almacen --}}
                                  <option value="{{$proveedor->id}}" >{{$proveedor->nombre}}</option>
                                @endforeach
                            </select>     
                          </div>
                      </div>
                      <div class="form-group col-lg-12 md-812 sm-12">
                          <label " class="col-lg-2 control-label form-label">Producto:</label>
                          <div class="col-lg-10">
                            <select id="producto" name="producto" onchange="cantidadAlmacen();" class="selectpicker form-control form-control-radius">
                              @foreach($productos as $producto)
                                 {{-- Solicita cantidad al almacen --}}
                                  <option value="{{$producto->id}}" >{{$producto->nombre}}</option>
                       
                              @endforeach
                            </select>     
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Precio: </label>
                          <div class="col-sm-10">
                            <input type="number" name="precio" placeholder="Empresa" min="0" value="0" class="form-control form-control-radius" >
                          </div>
                      </div>
                      
                       
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
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

@stop