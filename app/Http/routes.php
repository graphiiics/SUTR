<?php

use App\Empresa;
use App\Beneficio;
use App\Sesion;
use App\Signo;
use App\Paciente;
use App\Cbeneficio;
use App\Concepto;
use App\Crecibo;
use App\Pedido;
use App\Pedido_producto;
use App\Producto;
use App\Producto_proveedor;
use App\Producto_registro;
use App\Producto_unidad;
use App\Producto_venta;
use App\Proveedor;
use App\Unidad;
use App\User;
use App\Venta;
use App\Recibo;
use App\Registro;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'web'], function () {
    Route::auth();
   
   Route::get('/',function(){
        {
           if(Auth::check()){  
                    switch (Auth::user()->tipo) {

                        #Super_Administrador
                        case '1':
                           return redirect('superAdmin');
                            break;
                        #Administrador
                        case '2':
                            return redirect('admin');
                            break;
                        #Gerentee
                        case '3':
                            return redirect('gerente');
                            break;
                        
                        default:
                           return redirect('login');
                            break;
                    }
            }
            else{
                return redirect('login');
            }
        
        }
    });
});

//>>>>>>>>>>>>>>>>>>>>>>>Rutas Dentro del middleware Web<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<php


Route::group(['middleware'=>'web'],function(){

#Rutas para todos
  // Route::post('cambiarContrasena',['as' => 'cambiarContrasena', 'uses' => 'UserController@cambiarContrasena' ]);
    // Route::post('actualizarDatos',['as' => 'actualizarDatos', 'uses' => 'UserController@actualizarDatos' ]);

#Ruta Administrador
Route::group(['middleware' => 'admin','prefix'=>'admin'], function() {
   Route::get('/',['as'=>'inicio','uses'=>'HomeController@index']);
   //Rutas Productos
   Route::get('productos',['as'=>'productos','uses'=>'ProductoController@index']);
   Route::post('editarProducto/{producto}',['as'=>'editarProducto','uses'=> 'ProductoController@editarProducto'])->where('producto', '[0-9]+');
   Route::post('guardarProducto',['as'=>'guardarProducto','uses'=>'ProductoController@guardarProducto']);
   Route::get('cantidadAlmacen/{producto}',['as'=>'cantidadAlmacen','uses'=>'ProductoController@cantidadAlmacen'])->where('producto', '[0-9]+');
   Route::get('cantidadUnidad/{producto}',['as'=>'cantidadUnidad','uses'=>'ProductoController@cantidadUnidad'])->where('producto', '[0-9]+');
   //Rutas Proveedores
   Route::get('proveedores',['as'=>'proveedores','uses'=>'ProveedorController@index']);
   Route::post('guardarProveedor',['as'=>'guardarProveedor','uses'=>'ProveedorController@guardarProveedor']);
   Route::post('editarProveedor/{proveedor}',['as'=>'editarProveedor','uses'=> 'ProveedorController@editarProveedor'])->where('proveedor', '[0-9]+');
   Route::post('guardarProductoProveedor',['as'=>'guardarProductoProveedor','uses'=>'ProveedorController@guardarProductoProveedor']);

   Route::get('eliminarProveedor/{proveedor}',['as'=>'eliminarProveedor','uses'=>'ProveedorController@eliminarProveedor'])->where('proveedor', '[0-9]+');
   Route::get('productosProveedores',['as'=>'productosProveedores','uses'=>'ProveedorController@productosProveedores']);
   //Rutas Registros
   Route::get('registros',['as'=>'registros','uses'=>'RegistroController@index']);
   Route::post('guardarRegistro',['as'=>'guardarRegistro','uses'=>'RegistroController@guardarRegistro']);
   Route::get('eliminarRegistro/{registro}',['as'=>'eliminarRegistro','uses'=>'RegistroController@eliminarRegistro'])->where('registro', '[0-9]+');
   //Rutas Pedidos
   Route::get('pedidos',['as'=>'pedidos', 'uses'=>'PedidoController@index']);
   Route::post('guardarPedido',['as'=>'guardarPedido','uses'=>'PedidoController@guardarPedido']);
   Route::get('eliminarPedido/{pedido}',['as'=>'eliminarPedido','uses'=>'PedidoController@eliminarPedido'])->where('pedido', '[0-9]+');
   Route::get('recibirPedido/{pedido}',['as'=>'recibirPedido','uses'=>'PedidoController@recibirPedido'])->where('pedido', '[0-9]+');
   Route::post('emitirPedido/{pedido}',['as'=>'emitirPedido','uses'=>'PedidoController@emitirPedido'])->where('pedido', '[0-9]+');

   //Rutas Ventas
   Route::get('ventas',['as'=>'ventas', 'uses'=>'VentaController@index']);
   Route::post('guardarVenta',['as'=>'guardarVenta','uses'=>'VentaController@guardarVenta']);
   Route::get('liquidarVenta/{venta}',['as'=>'liquidarVenta','uses'=>'VentaController@liquidarVenta'])->where('venta', '[0-9]+');
   //Rutas Compras
   Route::get('compras',['as'=>'compras', 'uses'=>'CompraController@index']);
   Route::post('guardarCompra',['as'=>'guardarCompra','uses'=>'CompraController@guardarCompra']);
   Route::get('obtenerProveedor/{proveedor}',['as'=>'obtenerProveedor','uses'=>'CompraController@obtenerProveedor'])->where('proveedor', '[0-9]+');
   //Rutas Usuarios
   Route::get('usuarios',['as'=>'usuarios', 'uses'=>'UserController@index']);
   Route::post('editarUsuario/{usuario}',['as'=>'editarUsuario','uses'=>'UserController@editarUsuario'])->where('usuario', '[0-9]+');
   Route::post('guardarUsuario',['as'=>'guardarUsuario','uses'=>'UserController@guardarUsuario']);

   //Rutas Notificaciones
    Route::get('notificaciones',['as'=>'notificaciones', 'uses'=>'NotificacionController@index']);
    Route::get('suspenderNotificacion/{notificacion}',['as'=>'suspenderNotificacion', 'uses'=>'NotificacionController@suspenderNotificacion'])->where('notificacion', '[0-9]+');

 });
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  #Rutas Gerente
Route::group(['middleware' => 'gerente','prefix'=>'gerente'], function() {
   Route::get('/',['as'=>'inicioGerente','uses'=>'HomeController@index']);
   //Rutas Productos
   Route::get('productos',['as'=>'productosGerente','uses'=>'ProductoController@index']);
   Route::get('cantidadAlmacen/{producto}',['as'=>'cantidadAlmacenGerente','uses'=>'ProductoController@cantidadAlmacen'])->where('producto', '[0-9]+');
   Route::get('cantidadUnidad/{producto}',['as'=>'cantidadUnidadGerente','uses'=>'ProductoController@cantidadUnidad'])->where('producto', '[0-9]+');
   //Rutas Registros
   Route::get('registros',['as'=>'registrosGerente','uses'=>'RegistroController@index']);
   Route::post('guardarRegistro',['as'=>'guardarRegistroGerente','uses'=>'RegistroController@guardarRegistro']);
   
   //Rutas Pedidos
   Route::get('pedidos',['as'=>'pedidosGerente', 'uses'=>'PedidoController@index']);
   Route::post('guardarPedido',['as'=>'guardarPedidoGerente','uses'=>'PedidoController@guardarPedido']);
   Route::get('eliminarPedido/{pedido}',['as'=>'eliminarPedidoGerente','uses'=>'PedidoController@eliminarPedido'])->where('pedido', '[0-9]+');
   Route::get('recibirPedido/{pedido}',['as'=>'recibirPedidoGerente','uses'=>'PedidoController@recibirPedido'])->where('pedido', '[0-9]+');
    Route::get('agregarComentarioPedido/{pedido}',['as'=>'agregarComentarioPedido','uses'=>'PedidoController@agregarComentario'])->where('pedido', '[0-9]+');

   //Rutas Ventas
   Route::get('ventas',['as'=>'ventasGerente', 'uses'=>'VentaController@index']);
   Route::post('guardarVenta',['as'=>'guardarVentaGerente','uses'=>'VentaController@guardarVenta']);
   Route::get('liquidarVenta/{venta}',['as'=>'liquidarVentaGerente','uses'=>'VentaController@liquidarVenta'])->where('venta', '[0-9]+');

   //Rutas Notificaciones
    Route::get('notificaciones',['as'=>'notificacionesGerente', 'uses'=>'NotificacionController@index']);
    Route::get('suspenderNotificacion/{notificacion}',['as'=>'suspenderNotificacionGerente', 'uses'=>'NotificacionController@suspenderNotificacion'])->where('notificacion', '[0-9]+');

   
 });

  ///////////////////////////////////////////////////////
});


// //>>>>>>>>>>>>>>>>>>>>>>>PRUEBAS DE RELACIONES<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

// // Relacion one to many Sesion-Signo
// Route::get('signos_de_sesion/{id}', function ($id) {
//     $signos_de_sesion = Sesion::find($id)->signos;
// 	return ($signos_de_sesion);
// });

// Route::get('sesion_de_signo/{id}', function ($id) {
//     $sesion_de_signo = Signo::find($id)->sesion;
// 	return ($sesion_de_signo);
// });

// //Relacion one to many paciente-sesion
// Route::get('sesiones_de_paciente/{id}', function ($id) {
//     $sesiones_de_paciente = Paciente::find($id)->sesiones;
// 	return ($sesiones_de_paciente);
// });

// Route::get('paciente_de_sesion/{id}', function ($id) {
//     $paciente_de_sesion = Sesion::find($id)->paciente;
// 	return ($paciente_de_sesion);
// });

// //Relacion one to many paciente-recibo
// Route::get('recibos_de_paciente/{id}', function ($id) {
//     $recibos_de_paciente = Paciente::find($id)->recibos;
// 	return ($recibos_de_paciente);
// });

// Route::get('paciente_de_recibo/{id}', function ($id) {
//     $paciente_de_recibo = Recibo::find($id)->paciente;
// 	return ($paciente_de_recibo);
// });

// //Relacion one to many recibo-crecibos
// Route::get('crecibos_de_recibo/{id}', function ($id) {
//     $crecibos_de_recibo = Recibo::find($id)->crecibos;
// 	return ($crecibos_de_recibo);
// });

// Route::get('recibo_de_crecibo/{id}', function ($id) {
//     $recibo_de_crecibo = Crecibo::find($id)->recibo;
// 	return ($recibo_de_crecibo);
// });

// // Relacion one to many paciente-beneficio
// Route::get('beneficios_de_paciente/{id}', function ($id) {
//     $beneficios_de_paciente = Paciente::find($id)->beneficios;
//     return ($beneficios_de_paciente);
// });

// Route::get('paciente_de_beneficio/{id}', function ($id) {
//     $paciente_de_beneficio = Beneficio::find($id)->paciente;
//     return ($paciente_de_beneficio);
// });

// // Relacion one to many paciente-unidad
// Route::get('unidad_de_paciente/{id}', function ($id) {
//     $unidad_de_paciente = Paciente::find($id)->unidad;
//     return ($unidad_de_paciente);
// });

// Route::get('pacientes_de_unidad/{id}', function ($id) {
//     $pacientes_de_unidad = Unidad::find($id)->pacientes;
//     return ($pacientes_de_unidad);
// });

// // Relacion one to many recibo-unidad
// Route::get('recibos_de_unidad/{id}', function ($id) {
//     $recibos_de_unidad = Unidad::find($id)->recibos;
//     return ($recibos_de_unidad);
// });

// Route::get('unidad_de_recibo/{id}', function ($id) {
//     $unidad_de_recibo = Recibo::find($id)->unidad;
//     return ($unidad_de_recibo);
// });

// // Relacion one to many recibo-user
// Route::get('recibos_de_user/{id}', function ($id) {
//     $recibos_de_user = User::find($id)->recibos;
//     return ($recibos_de_user);
// });

// Route::get('user_de_recibo/{id}', function ($id) {
//     $user_de_recibo = Recibo::find($id)->user;
//     return ($user_de_recibo);
// });

// // Relacion one to many recibo-beneficio
// Route::get('recibos_de_beneficio/{id}', function ($id) {
//     $recibos_de_beneficio = Beneficio::find($id)->recibos;
//     return ($recibos_de_beneficio);
// });

// Route::get('beneficio_de_recibo/{id}', function ($id) {
//     $beneficio_de_recibo = Recibo::find($id)->beneficio;
//     return ($beneficio_de_recibo);
// });

// // Relacion one to many unidad-beneficio
// Route::get('beneficios_de_unidad/{id}', function ($id) {
//     $beneficios_de_unidad = Unidad::find($id)->beneficios;
//     return ($beneficios_de_unidad);
// });

// Route::get('unidad_de_beneficio/{id}', function ($id) {
//     $unidad_de_beneficio = Beneficio::find($id)->unidad;
//     return ($unidad_de_beneficio);
// });

// // Relacion one to many user-beneficio
// Route::get('beneficios_de_user/{id}', function ($id) {
//     $beneficios_de_user = User::find($id)->beneficios;
//     return ($beneficios_de_user);
// });

// Route::get('user_de_beneficio/{id}', function ($id) {
//     $user_de_beneficio = Beneficio::find($id)->user;
//     return ($user_de_beneficio);
// });

// // Relacion one to many cbeneficio-beneficio
// Route::get('cbeneficios_de_beneficio/{id}', function ($id) {
//     $cbeneficios_de_beneficio = Beneficio::find($id)->cbeneficios;
//     return ($cbeneficios_de_beneficio);
// });

// Route::get('beneficio_de_cbeneficio/{id}', function ($id) {
//     $beneficio_de_cbeneficio = Cbeneficio::find($id)->beneficio;
//     return ($beneficio_de_cbeneficio);
// });

// // Relacion one to many empresa-beneficio
// Route::get('beneficios_de_empresa/{id}', function ($id) {
//     $beneficios_de_empresa = Empresa::find($id)->beneficios;
//     return ($beneficios_de_empresa);
// });

// Route::get('empresa_de_beneficio/{id}', function ($id) {
//     $empresa_de_beneficio = Beneficio::find($id)->empresa;
//     return ($empresa_de_beneficio);
// });

// // Relacion one to many user-venta
// Route::get('ventas_de_user/{id}', function ($id) {
//     $ventas_de_user = User::find($id)->ventas;
//     return ($ventas_de_user);
// });

// Route::get('user_de_venta/{id}', function ($id) {
//     $user_de_venta = Venta::find($id)->user;
//     return ($user_de_venta);
// });

// // Relacion one to many user-pedido
// Route::get('pedidos_de_user/{id}', function ($id) {
//     $pedidos_de_user = User::find($id)->pedidos;
//     return ($pedidos_de_user);
// });

// Route::get('user_de_pedido/{id}', function ($id) {
//     $user_de_pedido = Pedido::find($id)->user;
//     return ($user_de_pedido);
// });

// // Relacion one to many user-registro
// Route::get('registros_de_user/{id}', function ($id) {
//     $registros_de_user = User::find($id)->registros;
//     return ($registros_de_user);
// });

// Route::get('user_de_registro/{id}', function ($id) {
//     $user_de_registro = Registro::find($id)->user;
//     return ($user_de_registro);
// });

// // Relacion one to many unidad-pedido
// Route::get('pedidos_de_unidad/{id}', function ($id) {
//     $pedidos_de_unidad = Unidad::find($id)->pedidos;
//     return ($pedidos_de_unidad);
// });

// Route::get('unidad_de_pedido/{id}', function ($id) {
//     $unidad_de_pedido = Pedido::find($id)->unidad;
//     return ($unidad_de_pedido);
// });

// // Relacion one to many unidad-registro
// Route::get('registros_de_unidad/{id}', function ($id) {
//     $registros_de_unidad = Unidad::find($id)->registros;
//     return ($registros_de_unidad);
// });

// Route::get('unidad_de_registro/{id}', function ($id) {
//     $unidad_de_registro = Registro::find($id)->unidad;
//     return ($unidad_de_registro);
// });

//Relacion many to many unidades-productos
Route::get('unidades_de_producto/{id}', function ($id) {
    $unidades_de_producto = Producto::find($id)->unidades;
	return ($unidades_de_producto);
});

Route::get('productos_de_unidad/{id}', function ($id) {
    $productos_de_unidad = Unidad::find($id)->productos;
	return ($productos_de_unidad);
});

// //Relacion many to many registros-productos
// Route::get('registros_de_producto/{id}', function ($id) {
//     $registros_de_producto = Producto::find($id)->registros;
//     return ($registros_de_producto);
// });

// Route::get('productos_de_registro/{id}', function ($id) {
//     $productos_de_registro = Registro::find($id)->productos;
//     return ($productos_de_registro);
// });

// //Relacion many to many proveedores-productos
// Route::get('proveedores_de_producto/{id}', function ($id) {
//     $proveedores_de_producto = Producto::find($id)->proveedores;
//     return ($proveedores_de_producto);
// });

// Route::get('productos_de_proveedor/{id}', function ($id) {
//     $productos_de_proveedor = Proveedor::find($id)->productos;
//     return ($productos_de_proveedor);
// });

// //Relacion many to many pedidos-productos
// Route::get('pedidos_de_producto/{id}', function ($id) {
//     $pedidos_de_producto = Producto::find($id)->pedidos;
//     return ($pedidos_de_producto);
// });

// Route::get('productos_de_pedido/{id}', function ($id) {
//     $productos_de_pedido = Pedido::find($id)->productos;
//     return ($productos_de_pedido);
// });

// //Relacion many to many ventas-productos
// Route::get('ventas_de_producto/{id}', function ($id) {
//     $ventas_de_producto = Producto::find($id)->ventas;
//     return ($ventas_de_producto);
// });

// Route::get('productos_de_ventas/{id}', function ($id) {
//     $productos_de_ventas = Venta::find($id)->productos;
//     return ($productos_de_ventas);
// });

// //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

// //TEST DE LOS LAYOUTS
// Route::get('menu_super', function()
// {
//     return View::make('layouts/super_admin');
// });

// Route::get('menu_admin', function()
// {
//     return View::make('layouts/admin');
// });

// Route::get('menu_gerente', function()
// {
//     return View::make('layouts/gerente');
// });


// //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
// //Recibos
// Route::get('consultar_recibos','ReciboController@consultar_recibos');

// //Conceptos
// Route::get('consultar_conceptos','ConceptoController@consultar_conceptos');
// Route::get('crear_concepto','ConceptoController@crear_concepto');
// Route::post('guardar_concepto', 'ConceptoController@guardar_concepto');
// Route::get('editar_concepto/{id}', 'ConceptoController@editar_concepto');
// Route::post('actualizar_concepto/{id}', 'ConceptoController@actualizar_concepto');