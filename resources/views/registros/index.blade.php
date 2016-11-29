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
@section('titulo') Registro 
@endsection
@section('tituloModulo')
Registro <i class="fa fa-home"></i>
@endsection
@section ('botones')
  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i> Crear Nuevo</a>
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
      <div class="panel-body table-responsive" id="tablaRegistros">
        <div class=" col-lg-3 col-sm-6  col-lg-offset-9">
            <div class="input-group">
              <input type="search" v-model="buscar" @click="RegistroBusqueda()" name="buscar" class="form-control" placeholder="Buscar">
              <span v-if="buscar.length>0" class="input-group-addon" @click="fetchItems(1)" >x</span>
            </div>
          </div>
        <table id="example0" class="table display">
          <thead>
            <tr>
              <th>Id</th>
              <th>Usuario</th>
              <th>Unidad</th>
              <th>Fecha</th>
              <th>Tipo</th>
              <th>Observaciones</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros |filterBy buscar">
              <td>@{{registro.id}}</td>
              <td>@{{registro.user.name}}</td>
              <td>@{{registro.unidad.nombre}}</td>
              <td>@{{registro.fecha}}</td>
              <td>@{{registro.tipo}}</td>
              <td>@{{registro.observaciones}}</td>
              <td><a  href="#"   data-toggle="modal" data-target="#modal@{{registro.id}}" class="btn btn-rounded btn-light">Ver detalles</a>
              <!-- Modal -->
                <div class="modal fade" id="modal@{{registro.id}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Detalles del registro @{{registro.id}} </h4>
                      </div>
                      <div class="modal-body">
                        <table class="table-striped " width="100%">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Id</th>
                              <th>Nombre</th>
                              <th>precio</th>
                              <th>Cantidad</th>
                              <th>Categoría</th>                            
                            </tr>
                          </thead>
                          <tbody  >
                            <tr v-for="producto in registro.productos ">
                              <td>@{{$index+1}}</td>
                              <td>@{{producto.id}}</td>
                              <td>@{{producto.nombre}}</td>
                              <template v-if="producto.categoria=='Suplemento'">
                                <td>$@{{producto.precio_venta}}</td> 
                              </template>
                              <template v-else>
                                <td>No disponible</td> 
                              </template>
                              <template v-if="producto.pivot.cantidad==1">
                                <td>@{{producto.pivot.cantidad}} @{{producto.presentacion}}</td>
                              </template>
                              <template v-else>
                                <td>@{{producto.pivot.cantidad}} @{{producto.presentacion}}s</td>
                              </template>
                              <td>@{{producto.categoria}}</td>
                            </tr>
                          </tbody>
                        </table>                  
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                        <a href="../registroPdf/@{{registro.id}}"  target="_blank" type="button" class="btn btn-default">Imprimir</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Code -->
              </td>
            </tr>
          </tbody>
        </table>
        <nav>
          <ul class="pagination">
              <li v-if="pagination.current_page > 1">
                  <a href="#" aria-label="Previous"
                     @click.prevent="changePage(pagination.current_page - 1)">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>
              <li v-for="page in pagesNumber"
                  v-bind:class="[ page == isActived ? 'active' : '']">
                  <a href="#"
                     @click.prevent="changePage(page)">@{{ page }}</a>
              </li>
              <li v-if="pagination.current_page < pagination.last_page">
                  <a href="#" aria-label="Next"
                     @click.prevent="changePage(pagination.current_page + 1)">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
    <!-- End Panel -->

  <!-- Modal -->
  <div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Nuevo Registro</h4>
        </div>
        @if(Auth::user()->tipo==1)
          <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarRegistro') }}">
        @elseif(Auth::user()->tipo==2)
          <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarRegistro') }}">
        @elseif(Auth::user()->tipo==3)
          <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarRegistroGerente') }}">
        @endif
          {!! csrf_field() !!}  
          <div  class="modal-body">  
           <div  class="form-group">
            <label class="col-sm-2 control-label form-label">Unidad: </label>
            <div class="col-sm-10">
              <select name="unidad" class="selectpicker form-control form-control-radius">
                  <option value="{{Auth::user()->unidad->id}}">{{Auth::user()->unidad->nombre}}</option>
                </select>                  
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label form-label">Tipo: </label>
            <div class="col-sm-10">
              <select name="tipo"  id="tipo" @change="limpiarProductos()" class="form-control form-control">
                  <option value="1">Entrada</option>
                  <option value="2">Salida</option>
                </select>                  
            </div>
          </div>
           <div class="form-group">
              <label class="col-sm-2 control-label form-label">Observaciones: </label>
              <div class="col-sm-10">
                <input type="text" name="observaciones" class="form-control form-control">             
              </div>
            </div>
            <div class="form-group ">
              <label  class="col-lg-2 md-2 control-label form-label">Producto:</label>
              <div class="col-lg-6 md-6">
                <select  v-model="producto"  id="producto" class="form-control form-control"  @change="datosProducto(producto)">
                  <option value="" >Selecciona un producto</option>
                  <option v-for="articulo in articulos" value="@{{articulo.key}}">
                    @{{articulo.nombre}} (@{{articulo.presentacion}})
                  </option>
                </select>     
              </div>
              <div class="col-lg-4 md-4">
                <div class=" pull-right">
                  <a  href="#" id="agregar" v-on:click="agregarProducto(producto)"  v-on:keyup.space="agregarProducto(producto)"  class="btn btn-rounded btn-success btn-icon"><i class="fa fa-plus"></i></a>
                </div>
                <div class="col-lg-8 md-8 input-group">
                    <input type="number" v-model="cantidad"  value="1" min="1" :max="cantidadMaxima" class="form-control form-control" >
                </div>
              </div>
              
            </div>
            <div class="form-group" >
              <table class="table-striped" width="100%">
                <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th width="40%">Producto</th>
                      <th width="15%">Categoría</th> 
                      <th width="15%">Cantidad</th> 
                      <th width="15%">Acciones</th>                   
                    </tr>
                </thead>
                <tbody id="bodyModal">
                  <tr v-for="producto in productos">
                    <td>@{{$index+1}}</td>
                    <td>@{{producto.nombre}}<input type="hidden" :name="'producto'+($index+1)" :value="producto.id_producto"></td>
                    <td>@{{producto.categoria}}</td>
                    <template v-if="!producto.editando">
                      <template v-if="producto.cantidad==1">
                        <td><input type="hidden" :name="'cantidad'+($index+1)"  class="form-control" :value="producto.cantidad">@{{producto.cantidad}} @{{producto.presentacion}} <input type="hidden" name=""></td>
                      </template>
                      <template v-else>
                        <td><input type="hidden" :name="'cantidad'+($index+1)"  class="form-control" :value="producto.cantidad">@{{producto.cantidad}} @{{producto.presentacion}}s</td>
                      </template>
                      <td><a  @click="editarProducto(producto)" class="btn btn-default btn-rounded btn-icon"><i class="fa fa-pencil"></i></a>
                      <a  @click="eliminarProducto(producto)" class="btn btn-danger btn-rounded btn-icon"><i class="fa fa-close"></i></a></td>
                    </template>
                    <template v-else>
                      <td>
                        <input v-model="producto.cantidad" type="number" min="1"  class="form-control">
                      </td>
                      <td>
                        <a  @click="actualizarProducto(producto)" class="btn btn-success btn-rounded btn-icon"><i class="fa fa-check"></i></a>
                      </td>
                    </template>
                  </tr> 
                  <input type="hidden" name="totalProductos" v-model="totalProductos">
                </tbody>
              </table> 
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" v-if="!enviando"  >Guardar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

      <!-- End Modal Code -->
    
      
 
 @endsection

 @section ('js')
  <script>
var tabla = new Vue({
    el: '#tablaRegistros',
    data: {
        pagination: {
            total: 0,
            per_page: 7,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,// left and right padding from the pagination <span>,just change it to see effects
        registros: [],
        buscar:"",
    },
        ready: function () {
            this.fetchItems(this.pagination.current_page);

        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
        },
        methods: {
            fetchItems: function (page) {
                var data = {page: page};
                this.$http.get('obtenerRegistros?page='+page,+'&search='+this.buscar).then(function (response) {
                    //look into the routes file and format your response
                    this.$set('registros', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                    //console.log(this.pedidos);
                    this.buscar='';
                }, function (error) {
                    // handle error
                });
            },
            changePage: function (page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            },
            RegistroBusqueda:function (argument) {
              this.$http.get('obtenerRegistroBusqueda' ).then(function (response) {
                    //look into the routes file and format your response
                    this.$set('registros', response.body);
                    
                  }, function (error) {
                      // handle error
                  });
            }
        }// termina Methods
    });
var nuevo = new Vue({
  
  el: '#modal_nuevo',
  data: { 
    enviando:false,
    id:0,
    producto:0,
    nombre:"",
    cantidad: 0,
    id_producto:0,
    productos:[],
    articulos:[],
    productosSalida:[],
    productosEntrada:[],
    unidad:'',
    categoria:'',
    presentacion:'',
    cantidadMaxima:0,
    editando:false,
    totalProductos:0,

  },
  methods: {
    agregarProducto: function (producto) {
      if(this.nombre!=""){
        if(this.cantidadMaxima<this.cantidad){
          this.cantidad=this.cantidadMaxima;
        }
        this.productos.push({id:this.id,id_producto:this.id_producto,nombre:this.nombre,precio:this.precio,cantidad:this.cantidad,editando:false,categoria:this.categoria,presentacion:this.presentacion});
        $("#producto option[value='"+producto+"']").remove();
        this.totalProductos=this.productos.length;
        this.nombre="";
        this.cantidad=1;   
      }      
    },
    obtenerProductos: function(){
        this.$http.get('productosEntrada').then((response) => {
        this.$set('productosEntrada',response.body)
        this.$set('articulos',response.body)
       });
         this.$http.get('productosSalida').then((response) => {
        this.$set('productosSalida',response.body)
       });
    },
    limpiarProductos: function(){
      this.producto=0;
      this.articulos=[];
      this.totalProductos=this.productos.length;
      this.nombre="";
      this.cantidad=1;    
      this.articulos=this.produc
    },
    datosProducto: function(index) {
      this.nombre= this.articulos[index].nombre+' ('+this.articulos[index].presentacion+')';
      this.cantidad=1;
      this.id=index;
      this.id_producto=this.articulos[index].id;
      this.cantidadMaxima=this.articulos[index].stock;
      this.categoria=this.articulos[index].categoria;
      this.presentacion=this.articulos[index].presentacion;
    },
    eliminarProducto:function(producto){
      $('#producto').append($('<option>', {
      value: producto.id,
      text: producto.nombre
      }));
      this.productos.$remove(producto)
      this.totalProductos=this.productos.length;
    },
    editarProducto: function(producto){
      producto.editando=true;
    },
    actualizarProducto: function(producto){
      producto.editando=false;
      
    },
    enviarVenta: function(){
      if(this.producto.length>0 && this.cliente.length>1)
        this.enviando=true 
    }
  },
  ready: function(){
      this.obtenerProductos();
     
  }
});

</script>
</script>


@stop