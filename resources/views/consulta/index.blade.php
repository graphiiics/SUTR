<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
  <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
  <title>Análisis Clinicos</title>

  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">

  </head>
  <body>
  <!-- Start Page Loading -->
  <div class="loading"><img src="img/loading.gif" alt="loading-img"></div>
  <!-- End Page Loading -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
  <!-- START TOP -->
  <div id="top" class="clearfix">

  	<!-- Start App Logo -->
  	<div class="applogo">
  		<a href="index.html" class="logo">UTRZAC</a>
  	</div>
  	<!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->


    <!-- Start Sidepanel Show-Hide Button -->
    <a href="#sidepanel" class="sidepanel-open-button-mobile"><i class="fa fa-user"></i></a>
    <!-- End Sidepanel Show-Hide Button -->

    <!-- Start Top Right -->
    <ul class="top-right">


    </ul>
    <!-- End Top Right -->

  </div>
  <!-- END TOP -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START SIDEBAR -->
<div class="sidebar clearfix">

  
  
  


</div>
<!-- END SIDEBAR -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Hoja de análisis Clinicos </h1>

    <!-- Start Page Header Right Div -->
<!-- esta por si se requiere de  poner algun botón
    <div class="right">
      <div class="btn-group" role="group" aria-label="...">
        <a href="index.html" class="btn btn-light">Dashboard</a>
        <a href="#" class="btn btn-light"><i class="fa fa-refresh"></i></a>
        <a href="#" class="btn btn-light"><i class="fa fa-search"></i></a>
        <a href="#" class="btn btn-light" id="topstats"><i class="fa fa-line-chart"></i></a>
      </div>
    </div>
-->
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">

  <div class="row">
    <form class="form-horizontal"  id="form" role="form" method="POST" action="imprimirHoja">
    {!! csrf_field() !!} 
      <div class="col-md-6">{{--  Datos inicia --}}
        <div class="panel panel-default">
          <div class="panel-title">
           
          </div>
            <div class="panel-body">
              <legend>Datos  paciente</legend>
              <div class="form-group">
                <div class="col-md-12" >
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" name="nombre" id="nombre">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6" >
                  <label for="edad" class="col-sm-2 control-label form-label">Edad</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name="edad" id="edad">
                  </div>
                </div>
                
                <div class="col-md-6">
                  <label for="sexo" class="col-sm-4 control-label form-label">Sexo</label>
                 <select class="col-sm-8 control-label form-label" id="sexo" name="sexo">
                   <option>Masculino</option>
                   <option>Femenino</option>
                 </select>
                </div>
              </div>

               <legend>Signos Vitales</legend>

                <div class="form-group">
                <div class="col-md-6" >
                  <label for="ta" class="col-sm-2 control-label form-label">T/A</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ta" id="ta">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="fc" class="col-sm-2 control-label form-label">F.C.</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="fc" id="fc">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="fr" class="col-sm-2 control-label form-label">F.R.</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="fr" id="fr">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="temp" class="col-sm-2 control-label form-label">Temp.</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="temp" id="temp">
                  </div>
                </div>
              </div>
              <div class="form-group">
                
                
                <div class="col-md-12" >
                 
                 
                  <div class="checkbox checkbox-inline">
                    <div class="checkbox checkbox-success checkbox-circle">
                      <input id="quimica" name="quimica" type="checkbox" >
                      <label for="quimica">
                          Quimica 13
                      </label>
                    </div>
                  </div>
                  <div class="checkbox checkbox-inline">
                      <div class="checkbox checkbox-success checkbox-circle">
                      <input id="orina" name="orina" type="checkbox" >
                      <label for="orina">
                          E.G.O
                      </label>
                    </div>
                  </div>
                  <div class="checkbox checkbox-inline">
                      <div class="checkbox checkbox-success checkbox-circle">
                      <input id="renal" name="renal" type="checkbox" >
                      <label for="renal">
                           Renal
                      </label>
                    </div>
                  </div>
                  <div class="checkbox checkbox-inline">
                      <div class="checkbox checkbox-success checkbox-circle">
                      <input id="serologia" name="serologia" type="checkbox" >
                      <label for="serologia">
                          Serología
                      </label>
                    </div>
                  </div>
                    <div class="checkbox checkbox-inline">
                      <div class="checkbox checkbox-success checkbox-circle">
                      <input id="sg" name="sg" type="checkbox" checked>
                      <label for="sg">
                          Signos
                      </label>
                    </div>
                  </div>

                  <a href="#" data-toggle="modal" data-target="#modelAnalisis"  onclick="obtenerDatos();"  class="btn btn-success pull-right"><i class="fa fa-print"></i>Imprimir</a> 
                    
                 
                </div>
              </div>

            </div>
        </div>
      </div>{{--  Datos Termina --}}
      
      <div class="col-md-6" id="quimica">{{--  Examen General de quimica 13 inicia --}}
        <div class="panel panel-default">
          <div class="panel-title">
            <ul class="panel-tools">
              <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
              <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
              <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
              
            </ul>
          </div>
            <div class="panel-body">
               <legend>Examen  General de Quimica 13</legend>
                <div class="form-group">
                <div class="col-md-6" >
                  <label for="alb-13" class="col-sm-2 control-label form-label">ALB</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="alb-13" id="alb-13">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="alf-13" class="col-sm-2 control-label form-label">ALF</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="alf-13" id="alf-13">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="alt-13" class="col-sm-2 control-label form-label">ALT</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="alt-13" id="alt-13">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="amy-13" class="col-sm-2 control-label form-label">AMY</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="amy-13" id="amy-13">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="ast-13" class="col-sm-2 control-label form-label">AST</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ast-13" id="ast-13">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="bun-13" class="col-sm-2 control-label form-label">BUN</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="bun-13" id="bun-13">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="ca-13" class="col-sm-2 control-label form-label">Ca</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ca-13" id="ca-13">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="cre-13" class="col-sm-2 control-label form-label">CRE</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cre-13" id="cre-13">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="ggt-13" class="col-sm-2 control-label form-label">GGT</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ggt-13" id="ggt-13">
                  </div>
                </div>
                 <div class="col-md-6" >
                  <label for="glu-13" class="col-sm-2 control-label form-label">GLU</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="glu-13" id="glu-13">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="tbil-13" class="col-sm-2 control-label form-label">TBIL</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="tbil-13" id="tbil-13">
                  </div>
                </div>
                 <div class="col-md-6" >
                  <label for="tp-13" class="col-sm-2 control-label form-label">TP</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="tp-13" id="tp-13">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="ua-13" class="col-sm-2 control-label form-label">UA</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ua-13" id="ua-13">
                  </div>
                </div>
                
                
              </div>

            </div>
        </div>
      </div>{{--  Examen General de Quimica 13 Termina --}}
      <div class="col-md-6" id="orina">{{--  EGO inicia --}}
        <div class="panel panel-default">
          <div class="panel-title">
            <ul class="panel-tools">
              <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
              <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
              <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
            </ul>
          </div>
            <div class="panel-body">
               <legend>Examen General de Orina</legend>
                <div class="form-group">
                
                </div>
                <div class="form-group">
                <div class="col-md-6" >
                  <label for="leu-orina" class="col-sm-2 control-label form-label">LEU</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="leu-orina" id="leu-orina">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="nit-orina" class="col-sm-2 control-label form-label">NIT</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nit-orina" id="nit-orina">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="pro-orina" class="col-sm-2 control-label form-label">PRO</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="pro-orina" id="pro-orina">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="ph-orina" class="col-sm-2 control-label form-label">pH</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="ph-orina" id="ph-orina">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="blo-orina" class="col-sm-2 control-label form-label">BLO</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="blo-orina" id="blo-orina">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="sg-orina" class="col-sm-2 control-label form-label">SG</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="sg-orina" id="sg-orina">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="ket-orina" class="col-sm-2 control-label form-label">KET</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ket-orina" id="ket-orina">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="bil-orina" class="col-sm-2 control-label form-label">BIL</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="bil-orina" id="bil-orina">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="glu-orina" class="col-sm-2 control-label form-label">GLU</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="glu-orina" id="glu-orina">
                  </div>
                </div>
                
                
              </div>
               <div class="form-group">
              </div>

            </div>
        </div>
      </div>{{--  EGO Termina --}}
       <div class="col-md-6" id="renal">{{--  Examen Panel Renal inicia --}}
        <div class="panel panel-default">
          <div class="panel-title">
            <ul class="panel-tools">
              <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
              <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
              <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
            </ul>
          </div>
            <div class="panel-body">
               <legend>Examen Panel Renal</legend>
                <div class="form-group">
                <div class="col-md-6" >
                  <label for="alb-renal" class="col-sm-2 control-label form-label">ALB</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="alb-renal" id="alb-renal">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="bun-renal" class="col-sm-2 control-label form-label">BUN</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="bun-renal" id="bun-renal">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="ca-renal" class="col-sm-2 control-label form-label">Ca</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="ca-renal" id="ca-renal">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="cl-renal" class="col-sm-2 control-label form-label">Cl</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cl-renal" id="cl-renal">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="cre-renal" class="col-sm-2 control-label form-label">CRE</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cre-renal" id="cre-renal">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="glu-renal" class="col-sm-2 control-label form-label">GLU</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="glu-renal" id="glu-renal">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="k-renal" class="col-sm-2 control-label form-label">K</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="k-renal" id="k-renal">
                  </div>
                </div>
                
                <div class="col-md-6" >
                  <label for="na-renal" class="col-sm-2 control-label form-label">Na</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="na-renal" id="na-renal">
                  </div>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-6" >
                  <label for="fos-renal" class="col-sm-2 control-label form-label">FOS</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="fos-renal" id="fos-renal">
                  </div>
                </div>
                 <div class="col-md-6" >
                  <label for="tco-renal" class="col-sm-2 control-label form-label">tCO</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="tco-renal" id="tco-renal">
                  </div>
                </div>
              </div>
              
            </div>
        </div>
      </div>{{--  Examen Panel Renal Termina --}}
      <div class="col-md-6" id="serologia">{{--  Serología inicia --}}
        <div class="panel panel-default">
          <div class="panel-title">
            <ul class="panel-tools">
              <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
              <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
              <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
            </ul>
          </div>
            <div class="panel-body">
               <legend>Serología</legend>
                 <div class="form-group">
                  <label for="vih" class="col-sm-4 control-label form-label">Anti-VIH:</label>
                 <select class="col-sm-8 control-label form-label" id="vih" name="vih">
                   <option>Negativo</option>
                   <option>Positivo</option>
                   <option>No realizada</option>
                 </select>
                </div>
                 <div class="form-group">
                  <label for="hbsag" class="col-sm-4 control-label form-label">Anti-HBsAg:</label>
                 <select class="col-sm-8 control-label form-label" id="hbsag" name="hbsag">
                   <option>Negativo</option>
                   <option>Positivo</option>
                   <option>No realizada</option>
                 </select>
                </div>
                 <div class="form-group">
                  <label for="hcv" class="col-sm-4 control-label form-label">Anti-HCV:</label>
                 <select class="col-sm-8 control-label form-label" id="hcv" name="hcv">
                   <option>Negativo</option>
                   <option>Positivo</option>
                   <option>No realizada</option>
                 </select>
                </div>
                
              
            </div>
        </div>
      </div>{{--  Serología Termina --}}
    </form>
  </div>
<!--Aqui va el código que contendra-->
</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<!-- //////////////////////////////////////////////////////////////////////////// -->   

<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- Modal -->
             <div class="modal fade" id="modelAnalisis" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hoja de Analisís</h4>
                  </div>
                   
                  <div  class="modal-body"  id="pdf">   
                    
                  </div>      
                
                    <div class="modal-footer">
                      <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                       
                    </div>
                </div>
                </form>
              </div>
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
<script type="text/javascript">

function obtenerDatos(){


        var dataString = $('#form').serialize();

       $('#pdf').html('<embed   src="imprimirHoja?'+dataString+'" width="100%" height="500px">')

}

    

</script>


</body>
</html>