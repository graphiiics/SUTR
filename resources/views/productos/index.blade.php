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
@section('titulo') Productos 
@endsection
@section('tituloModulo')
Productos <i class="fa fa-home"></i>
@endsection

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
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Real de Minas</th>
                        <th>San Agustin</th>
                        <th>Jerez</th>
                        <th>Rio Grande</th>
                        <th>Medica Norte</th>
                        <th>Tlaltenango</th>
                        <th>Almacén</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($productos as $producto)
                      <tr>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->nombre}}</td>
                        <td>${{$producto->precio}}</td>
                        <td>{{$producto->categoria}}</td>
                        @foreach($producto->unidades as $pUnidad)
                             <th>{{$pUnidad->pivot->cantidad}}</th>
                        @endforeach
                         <td><a  href="#" data-toggle="modal" data-target="#modal{{$producto->id}}" class="btn btn-rounded btn-light">Editar</a>
                            <!-- Modal -->
                                <div class="modal fade" id="modal{{$producto->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar {{$producto->nombre}}</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarProducto',$producto->id) }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre" value="{{$producto->nombre}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Precio: </label>
                                                <div class="col-sm-10">
                                                  <input type="number" step="any" name="precio" value="{{$producto->precio}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Categoría: </label>
                                              <div class="col-sm-10">
                                                <select name="categoria" value="{{$producto->categoria}}" class="selectpicker form-control form-control-radius">
                                                  @if($producto->categoria=="Medicamento")
                                                    <option selected>Medicamento</option>
                                                    <option>Suplemento</option>
                                                    <option>Material</option>
                                                  @elseif($producto->categoria=="Suplemento")
                                                    <option>Medicamento</option>
                                                    <option selected>Suplemento</option>
                                                    <option>Material</option>
                                                  @elseif($producto->categoria=="Material")
                                                    <option>Medicamento</option>
                                                    <option>Suplemento</option>
                                                    <option selected>Material</option>
                                                  @else
                                                    <option>Medicamento</option>
                                                    <option>Suplemento</option>
                                                    <option>Material</option>
                                                  @endif
                                                  </select>                  
                                              </div>
                                            </div>
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Real de Minas: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[0]->pivot->unidad_id}}" value="{{$producto->unidades[0]->pivot->cantidad}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">San Agustin: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[1]->pivot->unidad_id}}" value="{{$producto->unidades[1]->pivot->cantidad}}" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Jerez: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[2]->pivot->unidad_id}}" value="{{$producto->unidades[2]->pivot->cantidad}}" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Rio Grande: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[3]->pivot->unidad_id}}" value="{{$producto->unidades[3]->pivot->cantidad}}" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Medica Norte: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[4]->pivot->unidad_id}}" value="{{$producto->unidades[4]->pivot->cantidad}}" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Tlatenango: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[5]->pivot->unidad_id}}" value="{{$producto->unidades[5]->pivot->cantidad}}" class="form-control form-control-radius">
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Almacén: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$producto->unidades[6]->pivot->unidad_id}}" value="{{$producto->unidades[6]->pivot->cantidad}}" class="form-control form-control-radius">
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

                        </td>
                        
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
                                        <h4 class="modal-title">Nuevo Producto</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarProducto') }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre" class="form-control form-control-radius" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Precio: </label>
                                                <div class="col-sm-10">
                                                  <input type="number" step="any" name="precio"  class="form-control form-control-radius" required >
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Categoría: </label>
                                              <div class="col-sm-10">
                                                <select name="categoria" class="selectpicker form-control form-control-radius">
                                                    <option>Medicamento</option>
                                                    <option>Suplemento</option>
                                                    <option>Material</option>
                                                  </select>                  
                                              </div>
                                            </div>
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Real de Minas: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad1" value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">San Agustin: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad2" value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Jerez: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad3" value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Rio Grande: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad4" value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Medica Norte: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad5" value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div> 
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Tlatenango: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad6" value="0" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">Almacén: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad7" value="0" class="form-control form-control-radius" >
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