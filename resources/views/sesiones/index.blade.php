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
@section('titulo') Sesiones 
@endsection
@section('tituloModulo')
Sesiones <i class="fa fa-home"></i>
@endsection

@section ('botones')
@if(Auth::user()->tipo==3)
  
@endif
@endsection
@section('panelBotones')

  <li class="checkbox checkbox-primary">
  
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
                        @if(Auth::user()->tipo<=2)
                          <th>Unidad</th>
                        @endif
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Conecto</th>
                        <th>Desconecto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($recibos as $recibo)
                      <tr>
                        <td>{{$recibo->sesion->id}}</td>
                        @if(Auth::user()->tipo<=2)
                          <td>{{$recibo->unidad->nombre}}</td>
                        @endif
                        <td>{{$recibo->paciente->nombre}}</td>
                       
                        <td>{{$recibo->sesion->fecha}}</td>
                        
                        <td>{{$recibo->sesion->conecto}}</td>
                        <td>{{$recibo->sesion->desconecto}}</td>
                         
                        <td><a  href="{{route('hojaControlPdf',$recibo->sesion->id)}}"  class="btn btn-rounded btn-icon btn-info"><i title="Imprimir hoja de control" class="fa fa-print"></i></a>
                          
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
} );

function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
  });
}

</script>

@stop