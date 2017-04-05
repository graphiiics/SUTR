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
   elseif(Auth::user()->tipo==4)
  {
    $variable = "layouts.nutriologo";
  }
?>
@extends("$variable")
@section('titulo') Binvenido a SUTR  
@endsection
@section('opciones')
@endsection
@section('tituloModulo')
Inicio <i class="fa fa-home"></i>
@endsection
 @section('contenido')
        <!-- Start Second Row -->
  <div class="row">


    <!-- Start Server Status -->
    <div class="col-md-12 col-lg-4 col-lg-offset-4">
      <div class="panel panel-widget" >
        <div class="panel-title">
          <ul class="panel-tools panel-tools-hover">
            <li><a class="icon"><i class="fa fa-refresh"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>
        <div class="widget profile-widget" style="height:380px;">
        <h1>Bienvenid@ <h1>
        <img src="{{asset('img/perfil/'.Auth::user()->foto)}}" class="profile-image" alt="img">
        <h1><strong>{{Auth::user()->name}} </strong></h1>
          <p><i class="fa fa-map-marker"></i> Sistema de Unidad de Terapia Renal.</p>
         
          
       </div>
      </div>
    </div>
     
    
    <!-- End Server Status -->




  </div>
  <!-- End Second Row -->
 @endsection