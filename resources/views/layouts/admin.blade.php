<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
  <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
  <title>@yield('titulo', 'Unidad de Terapia Renal Zacatecas')</title>

  <!-- ========== Css Files ========== -->
 <link href="{{asset('css/root.css')}}" rel="stylesheet">
  @yield('css')

  </head>
  <body>
  <!-- Start Page Loading -->
  <!--div class="loading"><img src="img/loading.gif" alt="loading-img"></div-->
  <!-- End Page Loading -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
  <!-- START TOP -->
  <div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
      <a href="{{route('inicio')}}" class="logo">SUTR</a>
    </div>
    <!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->
   

    <!-- Start Sidepanel Show-Hide Button -->
    <a href="#sidepanel" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a>
    <!-- End Sidepanel Show-Hide Button -->

    <!-- Start Top Right -->
    <ul class="top-right">
      <li class="link">
      <a href="{{route('notificaciones')}}" class="notifications">{{count(Auth::user()->notificaciones)}}</a>
       </li>
    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="{{asset('img/perfil/'.Auth::user()->foto)}}" alt="img"><b>{{Auth::user()->name}}  (Administrador)</b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
         
          <li><a href="{{url('/logout')}}"><i class="fa falist fa-power-off"></i> Cerrar Sesión</a></li>
        </ul>
    </li>

    </ul>
    <!-- End Top Right -->

  </div>
  <!-- END TOP -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START SIDEBAR -->
<div class="sidebar clearfix">

<ul class="sidebar-panel nav">
  <li class="title">MENÚ</li>
  
  <li><a href="{{route('recibos')}}"><span class="icon color12"><i class="fa fa-tags"></i></span>Recibos</a>
  <li><a href="{{route('beneficios')}}"><span class="icon color12"><i class="fa fa-suitcase"></i></span>Beneficios</a>
  <li><a href="{{route('unidades')}}"><span class="icon color12"><i class="fa fa-university"></i></span>Unidades</a>
  <li><a href="{{route('pacientes')}}" ><span class="icon color12"><i class="fa fa-users"></i></span>Pacientes</a>
  <li><a href="{{route('sesiones')}}"><span class="icon color12"><i class="fa fa-stethoscope"></i></span>Sesiones</a>
  <li><a href="{{route('pedidos')}}"><span class="icon color12"><i class="fa fa-pencil-square-o"></i></span>Pedidos</a>
  <li><a href="{{route('registros')}}"><span class="icon color12"><i class="fa fa-bar-chart"></i></span>Registros</a>
  <li><a href="{{route('ventas')}}""><span class="icon color12"><i class="fa fa-dollar"></i></span>Ventas</a>
  <li><a href="{{route('conceptos')}}"><span class="icon color12"><i class="fa fa-cube"></i></span>Conceptos</a>
  <li><a href="{{route('empresas')}}"><span class="icon color12"><i class="fa fa-building"></i></span>Empresas</a>
  <li><a href="{{route('compras')}}"><span class="icon color12"><i class="fa fa-money"></i></span>Compras</a>
  <li><a href="{{route('proveedores')}}"><span class="icon color12"><i class="fa fa-truck"></i></span>Proveedores</a>
  <li><a href="{{route('productos')}}"><span class="icon color12"><i class="fa fa-flask"></i></span>Productos</a>
  <li><a href="{{route('usuarios')}}"><span class="icon color12"><i class="fa fa-male"></i></span>Usuarios</a>
  <li><a href="{{route('notificaciones')}}"><span class="icon color12"><i class="fa fa-envelope-o"></i></span>Notificaciones</a>
</ul>

<ul class="sidebar-panel nav">
  <li><a href="{{url('/logout')}}"><span class="icon color15"><i class="fa fa-lock"></i></span>Cerrar Sesión</a></li>
</ul>



</div>
<!-- END SIDEBAR -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">@yield('titulo', 'Title')</h1>


    <!-- Start Page Header Right Div -->
    <div  class="right col-lg-12 col-md-6">
    @yield('botones')
    </div>
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">

@yield('contenido')



</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<!-- Start Footer -->
<div class="row footer">
  <div class="col-md-12 text-center">
  Unidad de Terapia Renal S. C.
  </div>
</div>
<!-- End Footer -->


</div>
<div role="tabpanel" class="sidepanel">

 

  <!-- Tab panes -->
  <div class="tab-content">

    <!-- Start Today -->
    <div role="tabpanel" class="tab-pane active" >

      <div class="gn-title">Opciones</div>

      <ul >
        @yield('panelBotones')
        

      </ul>

    </div>
    <!-- End Today -->

    

  </div>

  </div>



<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>

<!-- ================================================
Bootstrap Select
================================================ -->
<script type="text/javascript" src="{{asset('js/bootstrap-select/bootstrap-select.js')}}"></script>

<!-- ================================================
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="{{asset('js/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>

<!-- ================================================
Moment.js
================================================ -->
<script type="text/javascript" src="{{asset('js/moment/moment.min.js')}}"></script>

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="{{asset('js/date-range-picker/daterangepicker.js')}}"></script>


<script src="{{asset('/js/vue.js')}}"></script>
<script src="{{asset('https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js')}}"></script>

<script src="{{asset('js/sweet-alert/sweet-alert.min.js')}}"></script>
@yield('js')

</body>
</html>