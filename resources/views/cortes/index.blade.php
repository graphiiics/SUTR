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
@section('titulo') Cortes 
@endsection
@section('tituloModulo')
Cortes <i class="fa fa-home"></i>
@endsection
@section ('botones')
<li class="checkbox checkbox-primary">
   @if(Auth::user()->tipo==2)
    <a href="{{route('ventas')}}"  class="btn btn-light"><i class="fa fa-dollar"></i>Ventas</a>
  @elseif(Auth::user()->tipo==3)
    <a href="{{route('ventasGerente')}}"  class="btn btn-light"><i class="fa fa-dollar"></i>Ventas</a>
  @endif
  </li>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
   @if(Auth::user()->tipo==2)
    <a href="{{route('ventas')}}"  class="btn btn-light"><i class="fa fa-dollar"></i>Ventas</a>
  @elseif(Auth::user()->tipo==3)
    <a href="{{route('ventasGerente')}}"  class="btn btn-light"><i class="fa fa-dollar"></i>Ventas</a>
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
                <th>Usuario</th>
                <th>Fecha inicio</th>
                <th>FEcha fin</th>
                <th>Importe total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cortes as $corte)
                <tr>
                  <td>{{$corte->id}}</td>
                  <td>{{$corte->user->name}}</td>
                  <td>{{$corte->fecha_inicio}}</td>
                  <td>{{$corte->fecha_corte}}</td>
                  <td>${{$corte->importe}}.00</td>
                  <td><a  href="#" data-toggle="modal" data-target="#modal{{$corte->id}}" class="btn btn-rounded btn-light">Ver detalles</a>
                  <!-- Modal -->
                    <div class="modal fade" id="modal{{$corte->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Detalles del corte</h4>
                          </div>
                          <div class="modal-body">
                             <table class="table-striped " width="100%">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Importe</th>                       
                                  </tr>
                                </thead>
                                <tbody  class="">
                                  @foreach ($corte->ventas as $num=> $venta)
                                    <tr>
                                      <td>{{$num+1}}</td>
                                      <td>{{$venta->cliente}}</td>
                                      <td>{{$venta->fecha}}</td>
                                      <td>${{$venta->importe}}.00</td>
                                    </tr>
                                  @endforeach
                                   <tr>
                                      <td></td>
                                      <td></td>
                                      <td>Total</td>
                                      <td>${{$corte->importe}}</td>
                                    </tr>
                                </tbody>
                            </table>                  
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
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
      
    
      
 
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
     cantidadUnidad();
} );
</script>


@stop 