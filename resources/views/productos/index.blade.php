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
@if(Auth::user()->tipo<=2)
  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
  <a href="#" onclick="descargarPDF()"  class="btn btn-light"><i class="fa fa-plus"></i> Imprimi</a>
@endif
@endsection
@section('panelBotones')

  <li class="checkbox checkbox-primary">
  @if(Auth::user()->tipo<=2)
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
  @endif
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
                         @if(Auth::user()->tipo<=2)
                        <th>Stock</th>
                        @endif
                          @foreach($unidades as $unidad)
                             @if(Auth::user()->tipo<=2)
                                 <th>{{$unidad->nombre}}</th>
                             @else 
                                  @if(Auth::user()->unidad_id==$unidad->id)
                                    <th>{{$unidad->nombre}}</th>
                                 @endif
                             @endif
                          @endforeach
                        @if(Auth::user()->tipo<=2)
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($productos as $producto)
                      <tr>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->nombre}}</td>
                         @if(Auth::user()->tipo<=2)
                          <td>${{$producto->precio}}</td>
                        @else
                          @if($producto->categoria=="Suplemento")
                            <td>${{$producto->precio}}</td>
                          @else
                            <td>No disponible</td>
                          @endif
                        @endif
                        <td>{{$producto->categoria}}</td>
                         @if(Auth::user()->tipo<=2)
                        <td>{{$producto->stock}}</td>
                        @endif
                          @foreach($producto->unidades as $pUnidad)
                            @if(Auth::user()->tipo<=2)
                              <th>{{$pUnidad->pivot->cantidad}}</th>
                            @else
                                 @if(Auth::user()->unidad_id==$pUnidad->id)
                                    <th>{{$pUnidad->pivot->cantidad}}</th>
                                 @endif
                            @endif

                          @endforeach
                      @if(Auth::user()->tipo<=2)
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
                                                  <input type="number" name="precio" min="0" value="{{$producto->precio}}" class="form-control form-control-radius">
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
                                             
                                            @foreach($unidades as $key=> $unidad)
                                           
                                            <div class="form-group col-lg-6 md-12">
                                                <label " class="col-sm-4 control-label form-label">{{$unidad->nombre}}: </label>
                                                <div class="col-sm-8">
                                                  <input type="number" name="unidad{{$unidad->id}}" value="{{$producto->unidades[$key]->pivot->cantidad}}" class="form-control form-control-radius" min="0">
                                                </div>
                                            </div>
                                             @endforeach
                                           
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
                        @endif
                        </tr>
                  @endforeach
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
        @if(Auth::user()->tipo<=2)
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
                                                  <input type="number" min="0" name="precio"  class="form-control form-control-radius" required >
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
                                            <div class="form-group">
                                                  <label " class="col-sm-2 control-label form-label">Stock mínimo: </label>
                                                  <div class="col-sm-10">
                                                    <input type="number" name="stock" value="0" min="0" class="form-control form-control-radius" pattern="/^\d*$/">
                                                  </div>
                                              </div>
                                            @foreach($unidades as $unidad)
                                               <div class="form-group col-lg-6 md-12">
                                                  <label " class="col-sm-4 control-label form-label">{{$unidad->nombre}}: </label>
                                                  <div class="col-sm-8">
                                                    <input type="number" name="unidad{{$unidad->id}}" value="0" min="0" class="form-control form-control-radius" >
                                                  </div>
                                              </div>
                                            @endforeach
                                           
                                            
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
                              @endif
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
</script>


@stop