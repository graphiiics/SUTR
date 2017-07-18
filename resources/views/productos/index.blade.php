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
 
  
    <button class="btn btn-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">
     <i class="fa fa-print"></i> Imprimir
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
        <li> <a href="{{route('productosPdf','Suplemento')}}"  target="_blank"  class="btn btn-light"></i>  Suplementos</a></li>
        <li> <a href="{{route('productosPdf','Medicamento')}}"  target="_blank"  class="btn btn-light"></i>  Medicamentos</a></li>
        <li> <a href="{{route('productosPdf','Material')}}"  target="_blank"  class="btn btn-light"></i>  Materiales</a></li>
        <li> <a href="{{route('productosPdf','Todos')}}"  target="_blank"  class="btn btn-light"></i>  Todos</a></li>
    </ul>
  
   
@endif
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    @if(Auth::user()->tipo<=2)
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
    @endif
  </li>
  
        <li class="checkbox checkbox-primary"> <a href="{{route('productosPdf','Suplemento')}}"  target="_blank"  class="btn btn-light cerrarPanel"><i class="fa fa-print"></i>  Suplementos</a></li>
        <li class="checkbox checkbox-primary"> <a href="{{route('productosPdf','Medicamento')}}"  target="_blank"  class="btn btn-light cerrarPanel"><i class="fa fa-print"></i>  Medicamentos</a></li>
        <li class="checkbox checkbox-primary"> <a href="{{route('productosPdf','Material')}}"  target="_blank"  class="btn btn-light cerrarPanel"><i class="fa fa-print"></i>  Materiales</a></li>
        <li class="checkbox checkbox-primary"> <a href="{{route('productosPdf','Todos')}}"  target="_blank"  class="btn btn-light cerrarPanel"><i class="fa fa-print"></i>  Todos</a></li>
  
    
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
                   
                    <th>Nombre</th>
                    <th>Presenteación</th>
                    @if(Auth::user()->tipo<=2)
                      <th>Precio compra</th>
                    @endif
                    @if(Auth::user()->tipo<=2)
                      <th>Stock Total</th>
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
                      
                      <td>{{$producto->nombre}} </td>
                      <td>{{$producto->categoria}}</td>
                      @if(Auth::user()->tipo<=2)
                        <td>${{$producto->precio}}</td>
                      @endif
                      @if(Auth::user()->tipo<=2)
                        <td>{{$producto->stock}} ({{$producto->presentacion}}s) </td>
                      @endif
                      @foreach($producto->unidades as $pUnidad)
                        @if(Auth::user()->tipo<=2)
                          <th>{{$pUnidad->pivot->cantidad}}</th>
                        @else
                          @if(Auth::user()->unidad_id==$pUnidad->id)
                            <th>{{$pUnidad->pivot->cantidad}}
                              @if($pUnidad->pivot->cantidad==1)
                                {{$producto->presentacion}}
                              @else
                                {{$producto->presentacion}}s
                              @endif
                            </th>
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
                                                <label class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre" value="{{$producto->nombre}}" class="form-control " >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label form-label">Precio Venta: </label>
                                                <div class="col-sm-10">
                                                  <input type="number" name="precio_venta" min="0" value="{{$producto->precio_venta}}" class="form-control ">
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Categoría: </label>
                                              <div class="col-sm-10">
                                                <select name="categoria" value="{{$producto->categoria}}" class="form-control ">
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
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Presentación: </label>
                                              <div class="col-sm-10">
                                                <select name="presentacion" value="{{$producto->presentacion}}" class="form-control ">
                                                  @if($producto->presentacion=="Pieza")
                                                    <option selected>Pieza</option>
                                                    <option>Paquete</option>
                                                    <option>Caja</option>
                                                  @elseif($producto->presentacion=="Paquete")
                                                    <option>Pieza</option>
                                                    <option selected>Paquete</option>
                                                    <option>Caja</option>
                                                  @elseif($producto->presentacion=="Caja")
                                                    <option>Pieza</option>
                                                    <option>Paquete</option>
                                                    <option selected>Caja</option>
                                                  @else
                                                    <option>Pieza</option>
                                                    <option>Paquete</option>
                                                    <option>Caja</option>
                                                  @endif
                                                  </select>                  
                                              </div>  
                                            </div> 
                                            @foreach($unidades as $key=> $unidad)
                                            <div class="form-group col-lg-12 md-12">
                                              <div class="form-group col-lg-6 md-12">
                                                  <label class="col-sm-4 control-label form-label">{{$unidad->nombre}}: </label>
                                                  <div class="col-sm-8">
                                                    <input type="number" name="cantidadUnidad{{$unidad->id}}" value="{{$producto->unidades->find($unidad->id)->pivot->cantidad}}" class="form-control " min="0">
                                                  </div>
                                              </div>
                                               <div class="form-group col-lg-6 md-12">
                                                  <label class="col-sm-4 control-label form-label">Stock minimo: </label>
                                                  <div class="col-sm-8">
                                                    <input type="number" name="productoMinimoUnidad{{$unidad->id}}" value="{{$producto->unidades->find($unidad->id)->pivot->stock_minimo}}" class="form-control " min="0">
                                                  </div>
                                              </div>
                                            </div>
                                             @endforeach
                                           
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          <button type="submit" class="btn btn-default"  >Guardar</button>
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
                                      <form class="form-horizontal" role="form"  method="POST" action="{{ route('guardarProducto') }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="nombre" class="form-control " required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label form-label">Precio venta: </label>
                                                <div class="col-sm-10">
                                                  <input type="number" min="0" name="precio_venta" value="0" class="form-control " required >
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Categoría: </label>
                                              <div class="col-sm-10">
                                                <select name="categoria" class="form-control ">
                                                    <option>Medicamento</option>
                                                    <option>Suplemento</option>
                                                    <option>Material</option>
                                                  </select>                  
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label form-label">Tipo: </label>
                                              <div class="col-sm-10">
                                                <select name="presentacion" class="form-control ">
                                                    <option>Paquete</option>
                                                    <option>Caja</option>
                                                    <option>Pieza</option>
                                                  </select>                  
                                              </div>
                                            </div>
                                            
                                            @foreach($unidades as $unidad)
                                               
                                              <div class="form-group col-lg-12 md-12">
                                              <div class="form-group col-lg-6 md-12">
                                                  <label class="col-sm-4 control-label form-label">{{$unidad->nombre}}: </label>
                                                  <div class="col-sm-8">
                                                    <input type="number" name="cantidadUnidad{{$unidad->id}}" value="0" class="form-control " min="0">
                                                  </div>
                                              </div>
                                               <div class="form-group col-lg-6 md-12">
                                                  <label class="col-sm-4 control-label form-label">Stock minimo: </label>
                                                  <div class="col-sm-8">
                                                    <input type="number" name="productoMinimoUnidad{{$unidad->id}}" value="0" class="form-control " min="0">
                                                  </div>
                                              </div>
                                            </div>
                                            @endforeach
                                           
                                            
                                        </div>
                                        <div id="loading" class="modal-footer">
                                          <button type="button"   class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          <button type="submit" class="btn btn-default" onclick="enviar();">Guardar</button>
                                         
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

function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});
}
</script>


@stop