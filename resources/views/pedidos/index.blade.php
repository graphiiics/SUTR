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
@section('titulo') 
  Pedidos 
@endsection
@section('tituloModulo')
  Pedidos <i class="fa fa-home"></i>
@endsection

@section ('botones')
  <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i> Crear Nuevo</a>
  </li>
@endsection
@section('contenido')        <!-- Start Panel -->
  <div class="col-md-12 col-lg-12">
    @if(Session::has('message'))
      <div  class="alert alert-{{ Session::get('class') }} alert-dismissable kode-alert-click">
        <strong>{{ Session::get('message')}} </strong>
      </div>
    @endif
    <div class="panel panel-default">
      <div class="panel-title">  
      </div>
      <div class="panel-body table-responsive" id="tablaPedidos">
      <input type="hidden" v-model="tipo_usuario" value="{{Auth::user()->tipo}}">
      <input type="hidden" v-model="usuario" value="{{Auth::user()->id}}">
        <table  class="table display">
          <thead>
            <tr>
              <th>Id</th>
              <th>Usuario</th>
              <th>Unidad</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Comentarios</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="pedido in pedidos |filterBy buscar" :class="{danger: pedido.estatus=='Pendiente',warning: pedido.estatus=='Realizado'}" >
              <td>@{{pedido.id}}</td>
              <td>@{{pedido.user.name}}</td>
              <td>@{{pedido.unidad.nombre}}</td>
              <td>@{{pedido.fecha}}</td>
              <td>@{{pedido.estatus}}</td>
              <td>@{{pedido.observaciones}}</td>
              <td><a  href="#" @click="mostrarProductos(pedido.productos)" data-toggle="modal" data-target="#modal@{{pedido.id}}" class="btn btn-rounded btn-light">Ver detalles</a>
                <!-- Modal -->
                <div class="modal fade" id="modal@{{pedido.id}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Detalles del pedido </h4>
                      </div>
                          <template v-if="tipo_usuario==2 && pedido.estatus=='Pendiente'" >
                          <form class="form-horizontal" v-if="" role="form" method="POST" action="emitirPedido/@{{pedido.id}}">
                           </form>
                        </template>
                         <template v-if="pedido.user_id==usuario && pedido.estatus=='Pendiente' ">
                         <form class="form-horizontal" v-if="" role="form" method="POST" action="emitirPedido/@{{pedido.id}}">
                           </form>
                         </template>
                          
                      <div class="modal-body">
                        
                        <table class="table-striped" width="100%">
                          <thead>
                            <tr>
                              <th width="5%">#</th>
                              <th>Nombre</th>
                              <th>Cantidad</th>
                              <th>Categoría</th>    
                              <th>Acciones</th>                       
                            </tr>
                          </thead>
                          <tbody >
                            <tr v-for="producto in productos ">
                              
                              <td>@{{$index+1}}</td>
                              <td>@{{producto.nombre}}<input type="hidden" :name="'productoEditar'+($index)" value="@{{producto.id}}"></td>
                               <template v-if=" pedido.estatus=='Pendiente'" >
                                  <template v-if="!producto.editando">
                                    <template v-if="producto.pivot.cantidad==1">
                                      <td>
                                        <input type="hidden" :name="'cantidadEditar'+($index)"  class="form-control" value="@{{producto.pivot.cantidad}}">@{{producto.pivot.cantidad}} @{{producto.presentacion}} 
                                      </td>
                                      <td>@{{producto.categoria}}</td>
                                    </template>
                                    <template v-else>
                                      <td>
                                        <input type="hidden" :name="'cantidadEditar'+($index)"  class="form-control" value="@{{producto.pivot.cantidad}}">@{{producto.pivot.cantidad}} @{{producto.presentacion}}s
                                       
                                      </td>
                                      <td>@{{producto.categoria}}</td>
                                    </template>
                                    <td>
                                      <a  @click="editarProducto(producto)" class="btn btn-default btn-rounded btn-icon"><i class="fa fa-pencil"></i></a>
                                      <a  @click="eliminarProducto(producto)" class="btn btn-danger btn-rounded btn-icon"><i class="fa fa-close"></i></a>
                                    </td>
                                  </template>
                                  <template v-else>
                                    <td>
                                      <input v-model="producto.pivot.cantidad" type="number" min="1"  max="@{{producto.stock}}" class="form-control">
                                    </td>
                                    <td>
                                      <a  @click="actualizarProducto(producto)" class="btn btn-success btn-rounded btn-icon"><i class="fa fa-check"></i></a>
                                    </td>
                                  </template>
                                </template>
                                <template v-else>
                                  <template v-if="producto.pivot.cantidad==1">
                                      <td>
                                        @{{producto.pivot.cantidad}} @{{producto.presentacion}} 
                                      </td>
                                      <td>@{{producto.categoria}}</td>
                                      <td>...</td>
                                    </template>
                                    <template v-else>
                                      <td>
                                        @{{producto.pivot.cantidad}} @{{producto.presentacion}}s
                                      </td>
                                      <td>@{{producto.categoria}}</td>
                                      <td>...</td>
                                    </template>
                                    
                                </template>

                              
                            </tr>
                          </tbody>
                        </table> 
                        <template v-if=" pedido.estatus=='Pendiente'">
                          <div class="form-group  ">
                            <label  class="col-lg-2 md-2 control-label form-label">Producto:</label>
                            <div class="col-lg-6 md-6">
                              <select  v-model="producto"  id="producto" class="form-control form-control"  @change="datosProducto(producto)">
                                <option value="" >Selecciona un producto</option>
                                <option v-for="articulo in articulos" value="@{{articulo.key}}">
                                  @{{articulo.nombre}} (@{{articulo.presentacion}})
                                </option>
                              </select>     
                            </div>
                           <div class="col-lg-2 md-8">
                              <div class="input-group">
                                  <input type="number" v-model="cantidad"  value="1" min="1" :max="cantidadMaxima" class="form-control form-control" >
                              </div>
                            </div>
                           <div class="col-lg-2 md-2">
                              <a  href="#" id="agregar" v-on:click="agregarProducto(producto)"  v-on:keyup.space="agregarProducto(producto)"  class="btn btn-rounded btn-success btn-icon"><i class="fa fa-plus"></i></a>
                            </div>
                          </div>
                        </template>
                      </div>
                       {!! csrf_field() !!}
                           <input type="hidden" name="totalProductos" v-model="totalProductos">
                      <div class="modal-footer">
                        <a type="button" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                        <template v-if="tipo_usuario==3 && pedido.estatus=='Realizado'">
                          <a  href="recibirPedido/@{{pedido.id}}" class="btn btn-warning" ">Recibir Pedido</a>
                        </template>
                        <template v-if="tipo_usuario==2 && pedido.estatus=='Pendiente'" >
                         
                           <button   type="submit" class="btn btn-warning">Emitir Pedido</button>
                           </form>
                        </template>
                        <template v-if="pedido.user_id==usuario && pedido.estatus=='Pendiente' ">
                        
                           <button   type="submit" class="btn btn-warning">Actulizar Pedido</button>
                          </form>
                          <a   @click="eliminarPedido(pedido.id)"  class="btn btn-danger" ">Eliminar Pedido</a>
                        </template>
                         
                        <a  href="../pedidoPdf/@{{pedido.id}}" target="_blank" class="btn btn-default">Imprimir</a>
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
          <h4 class="modal-title">Nuevo Pedido</h4>
        </div>
        @if(Auth::user()->tipo==1)
            <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedido') }}">
          @elseif(Auth::user()->tipo==2)
            <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedido') }}">
          @elseif(Auth::user()->tipo==3)
            <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedidoGerente') }}">
             {!! csrf_field() !!}   
          @endif
        <form  class="form-horizontal" role="form" method="POST" action="{{ route('guardarPedidoGerente') }}">
        <div  class="modal-body"> 
          <div  class="form-group">
            <label class="col-lg-2 sm-2  control-label form-label">Unidad: </label>
            <div class="col-lg-10 sm-10 ">
              <select name="unidad"  class="selectpicker form-control" >
                <option value="{{Auth::user()->undiad_id}}">{{Auth::user()->unidad->nombre}}</option>
              </select>                  
            </div>
          </div>
          <div class="form-group">
              <label  class="col-lg-2 sm-2 control-label form-label">Observaciones:</label>
              <div class="col-lg-10 sm-10">
                <input type="text"  name="observaciones"  placeholder=" Ejemplo: Necesito recetas y folios "  class="form-control" >
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
                    <th width="15%">#</th>
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
    el: '#tablaPedidos',
    data: {
        pagination: {
            total: 0,
            per_page: 7,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,// left and right padding from the pagination <span>,just change it to see effects
        pedidos: [],
        productos:[],
        buscar:'',
        buscando:false,
        empleado:0,
        articulos:[],
        cantidad: 0,
        cantidadMaxima:1,
        producto:0,
        id:0,
        nombre:"",
        id_producto:0,
        categoria:'',
        presentacion:'',
        tipo_usuario:0,
        usuario:0,
        totalProductos:0,

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
                this.$http.get('obtenerPedidos?page='+page,+'&search='+this.buscar).then(function (response) {
                    //look into the routes file and format your response
                    this.$set('pedidos', response.data.data.data);
                    this.$set('pagination', response.data.pagination);
                    //console.log(this.pedidos);
                    this.buscar='';
                }, function (error) {
                    // handle error
                });
            },
            mostrarProductos(productos){
              this.productos=productos;
               this.totalProductos=this.productos.length;
              //console.log(this.productos);
              this.obtenerProductos(this.productos[0].pivot.pedido_id);
            },
            eliminarProducto:function(producto){
              // $('#producto').append($('<option>', {
              // value: producto.id,
              // text: producto.nombre
              // }));
              this.productos.$remove(producto)
              this.totalProductos=this.productos.length;
            },
            editarProducto: function(producto){
              producto.editando=true;
            },
            actualizarProducto: function(producto){
              producto.editando=false;
            },
            obtenerProductos: function(pedido){
              this.$http.get('productosNoPedido/'+pedido).then((response) => {
                this.$set('articulos',response.body)
               
              })
            },
             agregarProducto: function (producto) {
              if(this.nombre!=""){
                if(this.cantidadMaxima<this.cantidad){
                  this.cantidad=this.cantidadMaxima;
                }
                this.productos.push(this.articulos[producto]);
                this.productos[this.productos.length-1].pivot.cantidad=this.cantidad;
                $("#producto option[value='"+producto+"']").remove();
                this.nombre="";
                this.cantidad=1;   
                this.totalProductos=this.productos.length;
              }      
            },
            changePage: function (page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
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
            eliminarPedido: function(pedido) {
              swal({
                  title: "¿Estas seguro de eliminar el pedido?", 
                  text: "¡Una vez elimindo ya no se podra regresar!", 
                  type: "warning", 
                  showCancelButton: true, 
                  confirmButtonColor: "#DD6B55", 
                  confirmButtonText: "Si, Eliminar!", 
                  closeOnConfirm: false 
                },
                function(){
                    tabla.$http.get("eliminarPedido/"+pedido).then(function (response) {
                      
                      if(response.body=="eliminada"){
                        swal("Eliminda!", "Proceso realizado correctamente.", "success");
                        tabla.fetchItems(1);
                      }else{
                        swal("Error!", "Error al Eliminar la venta", "danger");
                      }
                    
                    }, function (error) {
                      alert('Error al enviar los datos para Eliminar');
                    });
                    

                });//funcion Swal
            }
        }// termina Methods
    });
var nuevo = new Vue({
  
  el: '#modal_nuevo',
  data: { 
    enviando:false,
    id:0,
    producto:"",
    nombre:"",
    cantidad: 0,
    id_producto:0,
    productos: [],
    articulos:[],
    unidad:'',
    categoria:'',
    presentacion:'',
    cantidadMaxima:1,
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
      //console.log("hola")
      this.$http.get('productosPedidos').then((response) => {
        this.$set('articulos',response.body)
         //console.log(this.suplementos)  
       });
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

@stop
