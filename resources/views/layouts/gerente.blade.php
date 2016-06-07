<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
  <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
  <title>Sistema de Unidad de Terapia Renal</title>

  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">
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
      <a href="index.html" class="logo">SUTR</a>
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

    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="http://lorempixel.com/240/260/cats/?96448" alt="img"><b>Gerente</b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <li role="presentation" class="dropdown-header">Profile</li>
          <li><a href="#"><i class="fa falist fa-inbox"></i>Inbox<span class="badge label-danger">4</span></a></li>
          <li><a href="#"><i class="fa falist fa-file-o"></i>Files</a></li>
          <li><a href="#"><i class="fa falist fa-wrench"></i>Settings</a></li>
          <li class="divider"></li>
          <li><a href="#"><i class="fa falist fa-lock"></i> Lockscreen</a></li>
          <li><a href="#"><i class="fa falist fa-power-off"></i> Logout</a></li>
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
  
  <li><a href="#"><span class="icon color12"><i class="fa fa-tags"></i></span>Recibos</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-suitcase"></i></span>Beneficios</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-dollar"></i></span>Ventas</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-flask"></i></span>Productos</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-pencil-square-o"></i></span>Pedidos</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-bar-chart"></i></span>Registros</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-users"></i></span>Pacientes</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-font"></i></span>Sesiones</a>
  <li><a href="#"><span class="icon color12"><i class="fa fa-male"></i></span>Usuarios</a>
  </li>
  <li><a href="#"><span class="icon color14"><i class="fa fa-paper-plane-o"></i></span>Extra Pages<span class="caret"></span></a>
    <ul>
      <li><a href="#">Option 1</a></li>
      <li><a href="#">Option 2</a></li>
    </ul>
  </li>
</ul>

<ul class="sidebar-panel nav">
  <li><a href="#"><span class="icon color15"><i class="fa fa-lock"></i></span>Cerrar Sesión</a></li>
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
    <div class="right">
    @yield('botones')
    </div>
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">

@yield('contenido')

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<!-- Start Footer -->
<div class="row footer">
  <div class="col-md-12 text-center">
  Copyright © 2016 All rights reserved.
  </div>
</div>
<!-- End Footer -->


</div>



<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="js/plugins.js"></script>
@yield('js')
</body>
</html>