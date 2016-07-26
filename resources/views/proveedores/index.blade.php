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
@section('titulo') Proveedores 
@endsection
@section('tituloModulo')
Proveedores <i class="fa fa-home"></i>
@section ('botones')
<a href="{{route('productosProveedores')}}" class="btn btn-light"><i class="fa fa-dollar"></i>Precios de Productos</a>

<a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@endsection
@section('panelBotones')
<li class="checkbox checkbox-primary">
    <a href="{{route('productosProveedores')}}" class="btn btn-light"><i class="fa fa-dollar"></i>Precios de Productos</a>
  </li>
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
                        <th>Nombre</th>
                        <th>Gerente</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($proveedores as $proveedor)
                      <tr>
                        <td>{{$proveedor->id}}</td>
                        <td>{{$proveedor->nombre}}</td>
                        <td>{{$proveedor->gerente}}</td>
                        <td>{{$proveedor->telefono}}</td>
                        <td>{{$proveedor->correo}}</td>
                         <td><a  href="#" data-toggle="modal" data-target="#modal{{$proveedor->id}}" class="btn btn-rounded btn-light">Editar</a>
                            <!-- Modal -->
                                <div class="modal fade" id="modal{{$proveedor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar {{$proveedor->nombre}}</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarProveedor',$proveedor->id) }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre" value="{{$proveedor->nombre}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Gerente: </label>
                                                <div class="col-sm-10">
                                                  <input type="text"  name="gerente" value="{{$proveedor->gerente}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Teléfono: </label>
                                                <div class="col-sm-10">
                                                  <input type="tel" pattern="[0-9]{10}" name="telefono" value="{{$proveedor->telefono}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Correo: </label>
                                                <div class="col-sm-10">
                                                  <input type="email"  name="correo" value="{{$proveedor->correo}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                             
                                            
                                             
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          @if(Auth::user()->tipo!=1)
                                            <a  href="{{Route('eliminarProveedor',$proveedor->id)}}" type="button" class="btn btn-danger" >Eliminar</a>
                                          @endif
                                          <button type="submit" class="btn btn-default">Guardar</button>
                                        </div>
                                      </form>
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
                  <h4 class="modal-title">Nuevo proveedor</h4>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarProveedor') }}">
                  {!! csrf_field() !!}  
                  <div class="modal-body">
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Nombre: </label>
                          <div class="col-sm-10">
                            <input type="text" name="nombre" placeholder="Empresa" class="form-control form-control-radius" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Gerente: </label>
                          <div class="col-sm-10">
                            <input type="text"  name="gerente" placeholder="Nombre completo" class="form-control form-control-radius">
                          </div>
                      </div>
                       <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Teléfono: </label>
                          <div class="col-sm-10">
                            <input type="tel" pattern="[0-9]{10}"  name="telefono" placeholder="10 dígitos" class="form-control form-control-radius">
                          </div>
                      </div>
                       <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Correo: </label>
                          <div class="col-sm-10">
                            <input type="email"  name="correo" placeholder="Correo electrónico" class="form-control form-control-radius">
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