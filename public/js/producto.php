<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Canacintra | Zacatecas Network</title>

  <!-- core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link href="../css/responsiveslides.css" rel="stylesheet">
    <link href="../css/slider.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="../images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">

        

</head><!--/head-->

<body class="homepage" >
    <header id="header">
         <div class="top-bar">
          <div class="container" style="margin: 0 auto;">
              <div class="row">
                  <div class="col-sm-6 col-xs-4">
                      <a class="navbar-brand" href="../index.html"><img src="../images/logo.png" alt="logo" id="logo"></a>
                  </div>
                  <div class="col-sm-6 col-xs-8">

                      <ul class="nav navbar-nav" style="margin-top: 0px;">
                        <li><a href="../search.html">Directorio</a></li>
                        <li><a href="../info.html">Afíliate</a></li>
                        <li><a href="../contact.php">Nosotros</a></li>
                    </ul>
                    <ul class="social-share" style="margin-top: 10px; margin-left: 25px;">
                        <li><a href="https://www.facebook.com/canacintrazac/?fref=ts"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/CANACINTRAZACC"><i class="fa fa-twitter"></i></a></li>
                    </ul>

                    <!--
                     <div class="social">
                          <ul class="social-share">
                              <li><a href="https://www.facebook.com/canacintrazac/?fref=ts"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/CANACINTRAZACC"><i class="fa fa-twitter"></i></a></li>
                          </ul>
                     </div>-->
                  </div>
              </div>
          </div><!--/.container-->
      </div><!--/.top-bar-->
        <nav class="navbar navbar-inverse" role="banner">
            <div class="container" id="header-container" style="margin: 0 auto;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <div class="col-lg-7">
                            <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar empresas o productos">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                            </span>
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <li class="dropdown">
                            <a href="../products.html" class="dropdown-toggle" data-toggle="dropdown">Productos <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="../services.html">Categoría</a></li>
                                <li><a href="../services.html">Categoría</a></li>
                                <li><a href="../services.html">Categoría</a></li>
                                <li><a href="../services.html">Categoría</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="../contact.html" class="dropdown-toggle" data-toggle="dropdown">Servicios <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                              <li><a href="../services.html">Categoría</a></li>
                              <li><a href="../services.html">Categoría</a></li>
                              <li><a href="../services.html">Categoría</a></li>
                              <li><a href="../services.html">Categoría</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Mi Cuenta</a></li>
                        <li><a href="../info.html"><i class="fa fa-shopping-cart"></i> Mi Carrito</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->
    <div id="producto">
    <?php
      echo '<input type="hidden" v-model="id_producto" value="'.$_GET['cual'].'">';
    ?>
        <section id="thumbnail-gallery">
            <div class="container">
                <div class="center wow fadeInDown" style="padding-bottom: 20px;">
                    <h2 id="nombreProductos"> {{nombre}}</h2>
                </div>
                <div class="center wow fadeInDown" style="padding-bottom: 20px;">
                    <h2 style="color: #00994C; margin-bottom: 0px;" id="precioProductos" > ${{precio}}</h2><br>
                     <p id="empresa">Vendido por: <a href="http://drd.mx/canacintra/empresas/empresa.php?cual={{empresa[0].idEmpresa}}"> {{empresa[0].nombreComercialEmpresa}}</a></p>
                </div>
                <div id="main_area">
                    <!-- Slider -->
                    <div class="row">
                        <div class="col-sm-6"  id="pager">
                            <!-- Bottom switcher of slider -->
                            <!-- <ul id="slider-pager" >
                              <li class="col-sm-3" id="slider-pager" v-for="imagen in imagenes">
                                <a class="thumbnail" ><img  src="../images/products/product{{id_producto}}/{{imagen.nombreImagenesProductos}}"></a>
                              </li>

                            </ul> -->
                             
                        </div>
                        <div class="col-sm-6">
                            <div class="col-xs-12" id="slider">
                             
                            </div>
                        </div>
                        <!--/Slider-->
                    </div>
                </div>
                <div style="width= 100%; height: 15%;  margin:0 auto; text-align:center;">
                        <a href="{{empresa[0].webEmpresa}}}" class="btn btn-primary">Comprar ahora</a>
                </div>
             </div>
        </section><!--/#thumbnail-gallery-->
        <hr>
        <section id="recent-works">
            <div class="container">
                <div class="center wow fadeInDown" style="padding-bottom: 15px;">
                    <h2>Descripción</h2>
                </div>

                <div class="row" id="descripcionProductos">
                  <p>{{descripcion}} 
                      
                  </p>
                </div><!--/.row-->
                <div style="width= 100%; height: 15%;  margin:0 auto; text-align:center;">
                     <a href="{{empresa[0].webEmpresa}}}" class="btn btn-primary">Comprar ahora</a>
                </div>          
            </div><!--/.container-->
        </section><!--/#recent-works-->

        <section id="related-products">
          <div class="center wow fadeInDown" style="padding-bottom: 15px;">
              <h2>Productos Relacionados</h2>
          </div>
          <div v-for="producto in relacionados">
              
                <div class="col-xs-12 col-sm-4 col-md-3">
                  <div class="recent-work-wrap">
                    <a href="#"><img class="img-responsive" src="../images/portfolio/recent/raspberry.jpg" alt="">
                        <div id="product-desc">
                          <h4>{{producto.nombreProductos}}</h4>
                            <p>{{producto.descripcionProductos}}</p><strong><p>${{producto.precioProductos}}</p></strong>
                        </div>
                    </a>
                  </div>
                </div>
              

          </div>
        </section>
    </div>
    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2016 <a target="_blank" href="#" title="">Canacintra</a>. Todos los derechos reservados.
                </div>
                <div class="col-sm-6">
                   <p class="pull-right">Blvd. López Portillo No. 100,  Fracc. Dependencias Federales,  Guadalupe, Zac.</p>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    
   
</body>
</html>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.prettyPhoto.js"></script>
<script src="../js/jquery.isotope.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/wow.min.js"></script>
<script src="../js/thumbnail.js"></script>
<script src="../js/vue.js"></script> <!-- Framework Vue -->
<script src="https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js"></script> <!-- libreria para trabajar resource
 -->
<script src="../js/responsiveslides.min.js"></script>
<script type="text/javascript">

    var app = new Vue({
      
      el: '#producto',
      data: { 
        id_producto:0,
        precio:0,
        producto:[],
        nombre:"",
        descripcion:"",
        empresa: [],
        relacionados:[],
        imagenes:[],
        slider:"",
        images:"",
        imgRelacion:[],
        controlImg:0,
      },
      ready: function () {
        this.cargarContenido();

      },
      methods: {
        cargarContenido: function () {
            this.$http.get('http://drd.mx/canacintra/service/get/getProductosId.php?cual='+this.id_producto).then((response) => { // obtenemos los datos desde el servidor
             this.$set('producto',JSON.parse(response.body)); // agregamos los datos al arreglo y los pasamos a JSON
             //console.log(this.producto)  
             // agreamos los datos obtenidos a las variables para poder ser mostrados
              this.precio=this.producto[0].precioProductos;
              this.nombre=this.producto[0].nombreProductos;
              this.descripcion=this.producto[0].descripcionProductos;
              //obtenemos la empresa
              this.$http.get('http://drd.mx/canacintra/service/get/getEmpresaId.php?cual='+this.producto[0].Empresa_idEmpresa).then((response) => { // obtenemos los datos desde el servidor
                this.$set('empresa',JSON.parse(response.body)); // agregamos los datos al arreglo y los pasamos a JSON
                //console.log(this.producto)  
              });
              // obtenemos los productos relacionados
              this.$http.get('http://drd.mx/canacintra/service/get/getProductosId2.php?cual='+this.producto[0].Categoria_idCategoria).then((response) => { // obtenemos los datos desde el servidor
                this.$set('relacionados',JSON.parse(response.body)); // agregamos los datos al arreglo y los pasamos a JSON
                this.buscarRelacionados();
               
              });
               // obtenemos las imagenes 
              this.$http.get('http://drd.mx/canacintra/service/get/getImagenesProductosId.php?cual='+this.id_producto).then((response) => { // obtenemos los datos desde el servidor
                //console.log(response);  
                this.$set('imagenes',JSON.parse(response.body)); // agregamos los datos al arreglo y los pasamos a JSON
               // this.cambiarImagen(this.imagenes[0].nombreImagenesProductos);
                    this.cargarImagenes();
                    $(".rslides").responsiveSlides({
                        auto: true,
                        maxwidth: 800,           // Boolean: Animate automatically, true or false
                        speed: 500,            // Integer: Speed of the transition, in milliseconds
                        timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
                        pager: true,     
                        manualControls: '#slider-pager'
                      });
              }); 
            }); 
        },
        buscarRelacionados: function(){
          //console.log(Object.keys(this.relacionados).length);
          for(var i = 0; i < Object.keys(this.relacionados).length; i++) {
           // alert('bue');
           this.controlImg=i;
            if(this.relacionados[i].idProductos==this.id_producto){
             // alert('bue3');
              Vue.delete(this.relacionados, i);
              //this.relacionados.$remove(this.relacionados[i]);
            }else{

              this.$http.get('http://drd.mx/canacintra/service/get/getImagenesProductosId.php?cual='+this.relacionados[i].idProductos).then((response) => { // obtenemos los datos desde el servidor
                this.$set('imgRelacion',JSON.parse(response.body)); // agregamos los datos al arreglo y los pasamos a JSON
                alert(this.controlImg);
                this.relacionados[this.controlImg].Empresa_Giro_idGiro=this.imgRelacion[0].nombreImagenesProductos;
               
              }); 
              

            }
            
          }
         
          while(true){
              if(Object.keys(this.relacionados).length>4){
                Vue.delete(this.relacionados,Math.floor((Math.random() * Object.keys(this.relacionados).length) + 1));
              }else{
                 break;
              }
              
          }
        },
        cargarImagenes: function(){
       
          this.images+= '<ul  class="hide-bullets" id="slider-pager">';
          this.slider='<ul class="rslides">';
        
          for (var i = 0; i < Object.keys(this.imagenes).length; i++) {

              this.images+='<li class="col-sm-3"><a class="thumbnail" href="" ><img src="../images/products/product'+this.id_producto+'/'+this.imagenes[i].nombreImagenesProductos+'" alt=""></a></li>';
              this.slider+='<li><img src="../images/products/product'+this.id_producto+'/'+this.imagenes[i].nombreImagenesProductos+'" alt=""></li>';
          }
          this.images+= '</ul>';
          this.slider+='</ul>';
          $('#pager').html(this.images);
          $('#slider').html(this.slider);
        },

      },
      
      
    })
</script>