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
<a href="crear_concepto" class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@stop
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
                        <th>Real de Minas</th>
                        <th>San Agustin</th>
                        <th>Jerez</th>
                        <th>Rio Grande</th>
                        <th>Medica Norte</th>
                        <th>Tlatenango</th>
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
                        
                        <td><a  href="" class="btn btn-rounded btn-light">Editar</a></td>
                       
                    </tr>
                  @endforeach
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
</script>

@stop