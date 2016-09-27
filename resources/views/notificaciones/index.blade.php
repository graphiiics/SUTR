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
@section('titulo') Notificaciones 
@endsection
@section('tituloModulo')
Notificaciones <i class="fa fa-home"></i>
@endsection

@section ('botones')

@endsection
@section('panelBotones')
  
@endsection
 @section('contenido')
       
       <div class="row">

       @foreach($notificaciones as $notificacion)
       
          <!-- Start Panel -->
          <div class="col-md-6 col-lg-4">
          @if($notificacion->tipo=="Pedidos")
            <div class="panel panel-success">
          @elseif($notificacion->tipo=="Ventas")
            <div class="panel panel-warning">
          @elseif($notificacion->tipo=="Mensajes")
            <div class="panel panel-info">
          @elseif($notificacion->tipo=="Productos")
          <div class="panel panel-danger">
          @endif

              <div class="panel-title">
                Notificación de {{$notificacion->emisor}}
                <ul class="panel-tools">
                   @if(Auth::user()->tipo==1)
                     <li><a href="{{route('suspenderNotificacion',$notificacion->id)}}" ><i class="fa fa-times"></i></a></li>
                
                  @elseif(Auth::user()->tipo==2)
                     <li><a href="{{route('suspenderNotificacion',$notificacion->id)}}" ><i class="fa fa-times"></i></a></li>
                
                  @elseif(Auth::user()->tipo==3)
                     <li><a href="{{route('suspenderNotificacionGerente',$notificacion->id)}}" ><i class="fa fa-times"></i></a></li>
                
                  @endif
                  
                </ul>
              </div>

              <div class="panel-body">
                {{$notificacion->mensaje}}
                <p>Fecha: {{$notificacion->created_at}}</p>
                <div class="left">
                  @if(Auth::user()->tipo==1)
                    <a type="button" class="btn btn-info" href="{{url('superAdmin/'.$notificacion->link)}}">Ir a {{$notificacion->tipo}}</a>
                
                  @elseif(Auth::user()->tipo==2)
                    <a type="button" class="btn btn-info" href="{{url('admin/'.$notificacion->link)}}">Ir a {{$notificacion->tipo}}</a>
                
                  @elseif(Auth::user()->tipo==3)
                    <a type="button" class="btn btn-info" href="{{url('gerente/'.$notificacion->link)}}">Ir a {{$notificacion->tipo}}</a>
                
                  @endif
                   
                </div>
               

              </div>

            </div>
          </div>
          <!-- End Panel -->
        @endforeach

       </div>
 
 
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
</script>


@stop
