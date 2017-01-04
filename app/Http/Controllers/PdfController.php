<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Fpdf;
use Response;
use App\Pedido;
use App\Venta;
use App\Compra;
use App\Registro;
use App\Unidad;
use App\Producto;
use App\User;
use App\Proveedor;
use App\Ingreso;
use App\Egreso;
use App\Corte;
use App\Recibo;
use Auth;
class PdfController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
    }
    public function registroPdf(Registro $registro)
	{
		$contadorPaginas=1;
		$header = ['#', 'Nombre','Categoria','Cantidad'];
			Fpdf::AddPage();

		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			if($registro->tipo==1){
				Fpdf::Cell(180,20,'Registro (Entrada)',0	,0,'C'); 
			}else{
				Fpdf::Cell(180,20,'Registro (Salida)',0	,0,'C'); 
			}
			Fpdf::Cell(180,20,'Registro',0	,0,'C'); 
			Fpdf::ln(15);
			//Emisor	
			Fpdf::SetFontSize(10);
			Fpdf::Cell(60,10,'Realizado por: '.utf8_decode($registro->user->name),0	,0,'C');
			//Unidad
			Fpdf::Cell(60,10,'Fecha : '.$registro->fecha,0,0,'C');
			Fpdf::Cell(60,10,'Unidad: '.utf8_decode($registro->unidad->nombre),0	,0,'C');

		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			Fpdf::Ln();
			Fpdf::SetFont('times','B',12);
			Fpdf::SetFillColor(200,220,255);
			
				Fpdf::Cell(30,6,$header[0],1,0,'C',true);
				Fpdf::Cell(90,6,$header[1],1,0,'C',true);
				Fpdf::Cell(30,6,$header[2],1,0,'C',true);
				Fpdf::Cell(30,6,$header[3],1,0,'C',true);
			
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',10);
			foreach ($registro->productos as $key => $producto) {
				
				Fpdf::Cell(30,6,$key+1,1,0,'C');
				Fpdf::Cell(90,6,utf8_decode($producto->nombre),1,0,'L');
				Fpdf::Cell(30,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion,1,0,'L');
				else
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion.'s',1,0,'L');
				Fpdf::Ln();

			}
			Fpdf::Ln();			
		////////////////// tabla fin

		///////////Comentario Inicio
			Fpdf::Cell(180,20,'Comentarios: '.utf8_decode($registro->observaciones),0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Registro'.$registro->id.'_'.$registro->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Registro'.$registro->id.'_'.$registro->fecha.'.pdf'), 200,$headers); 
		
	}
		public function pedidoPdf(Pedido $pedido)
	{
		$contadorPaginas=1;
		$header = ['#', 'Nombre','Categoria','Cantidad'];
			Fpdf::AddPage();

		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(180,20,'Pedido',0	,0,'C'); 
			Fpdf::ln(15);
			//Emisor	
			Fpdf::SetFontSize(10);
			Fpdf::Cell(60,10,'Realizado por: '.utf8_decode($pedido->user->name),0	,0,'C');
			//Unidad
			Fpdf::Cell(60,10,'Fecha : '.$pedido->fecha,0,0,'C');
			Fpdf::Cell(60,10,'Unidad: '.utf8_decode($pedido->unidad->nombre),0	,0,'C');

		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			Fpdf::Ln();
			Fpdf::SetFont('times','B',12);
			Fpdf::SetFillColor(200,220,255);
			
				Fpdf::Cell(30,6,$header[0],1,0,'C',true);
				Fpdf::Cell(90,6,$header[1],1,0,'C',true);
				Fpdf::Cell(30,6,$header[2],1,0,'C',true);
				Fpdf::Cell(30,6,$header[3],1,0,'C',true);
			
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',10);
			foreach ($pedido->productos as $key => $producto) {
				
				Fpdf::Cell(30,6,$key+1,1,0,'C');
				Fpdf::Cell(90,6,utf8_decode($producto->nombre),1,0,'L');
				Fpdf::Cell(30,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion,1,0,'L');
				else
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion.'s',1,0,'L');
				Fpdf::Ln();

			}
			Fpdf::Ln();			
		////////////////// tabla fin

		///////////Comentario Inicio
			Fpdf::Cell(180,20,'Comentarios: '.$pedido->observaciones,0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Pedido_'.$pedido->id.'_'.$pedido->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Pedido_'.$pedido->id.'_'.$pedido->fecha.'.pdf'), 200,$headers);
        
		
	}

		public function ventaPdf(Venta $venta)
	{
		
		$header = ['#', 'Nombre','Categoria','Cantidad','Precio U.', 'Precio T.'];
			Fpdf::AddPage();

		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Venta',0	,0,'C'); 
			//Emisor	
			Fpdf::SetFontSize(10);
				if($venta->pago==1){
					Fpdf::Cell(60,20,'Efectivo (Liquidado)',0	,0,'C');
				}else{
					if($venta->estatus==1){
						Fpdf::Cell(60,20,'Credito (Liquidado) el '.$venta->fecha_liquidacion,0	,0,'C');
					}else{
						Fpdf::Cell(60,20,'Credito (Pendiente)',0	,0,'C');
					}
				}
			Fpdf::ln(15);
			Fpdf::Cell(60,10,'Realizada por: '.utf8_decode($venta->user->name),0	,0,'C');
			//Unidad
			Fpdf::Cell(60,10,'Fecha : '.$venta->fecha,0,0,'C');
			Fpdf::Cell(60,10,'Cliente: '.utf8_decode($venta->cliente),0	,0,'C');

		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			Fpdf::Ln();
			Fpdf::SetFont('times','B',12);
			Fpdf::SetFillColor(200,220,255);
			
				Fpdf::Cell(20,6,$header[0],1,0,'C',true);
				Fpdf::Cell(50,6,$header[1],1,0,'C',true);
				Fpdf::Cell(30,6,$header[2],1,0,'C',true);
				Fpdf::Cell(30,6,$header[3],1,0,'C',true);
				Fpdf::Cell(25,6,$header[4],1,0,'C',true);
				Fpdf::Cell(25,6,$header[5],1,0,'C',true);
			
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',10);
			foreach ($venta->productos as $key => $producto) {
				
				Fpdf::Cell(20,6,$key+1,1,0,'C');
				Fpdf::Cell(50,6,utf8_decode($producto->nombre),1,0,'L');
				Fpdf::Cell(30,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion,1,0,'L');
				else
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion.'s',1,0,'L');
				Fpdf::Cell(25,6,'$'.$producto->pivot->precio.'.00',1,0,'L');
				Fpdf::Cell(25,6,'$'.($producto->pivot->precio*$producto->pivot->cantidad).'.00',1,0,'L');
				Fpdf::Ln();

			}
			
		////////////////// tabla Cuerpo fin
		////// Tabla Footer Inicio
				Fpdf::Cell(130);
				Fpdf::Cell(25,6,'Total: ',1,0,'R',true);
				Fpdf::Cell(25,6,'$'.$venta->importe.'.00',1,0,'L',true);
				Fpdf::Ln();
		////   Tabla Footer Fin
		///////////Comentario Inicio
			Fpdf::Cell(180,20,'Comentarios: '.utf8_decode($venta->observaciones),0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Venta'.$venta->id.'_'.$venta->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Venta'.$venta->id.'_'.$venta->fecha.'.pdf'), 200,$headers);
        
		
	}

	 

	public function compraPdf(Compra $compra)
	{
		
		$header = ['#', 'Nombre','Categoria','Cantidad','Precio U.', 'Precio T.'];
			Fpdf::AddPage();

		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Compra',0	,0,'C'); 
			
			//Emisor	
			Fpdf::SetFontSize(10);
				
			Fpdf::ln(15);
			Fpdf::Cell(60,10,'Realizada por: '.utf8_decode($compra->user->name),0	,0,'C');
			//Unidad
			Fpdf::Cell(60,10,'Fecha : '.$compra->fecha,0,0,'C');
			Fpdf::Cell(60,10,'Proveedor: '.utf8_decode($compra->proveedor->nombre),0	,0,'C');
		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			Fpdf::Ln();
			Fpdf::SetFont('times','B',12);
			Fpdf::SetFillColor(200,220,255);
			
				Fpdf::Cell(20,6,$header[0],1,0,'C',true);
				Fpdf::Cell(50,6,$header[1],1,0,'C',true);
				Fpdf::Cell(30,6,$header[2],1,0,'C',true);
				Fpdf::Cell(30,6,$header[3],1,0,'C',true);
				Fpdf::Cell(25,6,$header[4],1,0,'C',true);
				Fpdf::Cell(25,6,$header[5],1,0,'C',true);
			
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',10);
			foreach ($compra->productos as $key => $producto) {
				
				Fpdf::Cell(20,6,$key+1,1,0,'C');
				Fpdf::Cell(50,6,utf8_decode($producto->nombre),1,0,'L');
				Fpdf::Cell(30,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion,1,0,'L');
				else
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion.'s',1,0,'L');
				Fpdf::Cell(25,6,'$'.$producto->pivot->precio.'.00',1,0,'L');
				Fpdf::Cell(25,6,'$'.($producto->pivot->precio*$producto->pivot->cantidad).'.00',1,0,'L');
				Fpdf::Ln();

			}
			
		////////////////// tabla Cuerpo fin
		////// Tabla Footer Inicio
				Fpdf::Cell(130);
				Fpdf::Cell(25,6,'Total: ',1,0,'R',true);
				Fpdf::Cell(25,6,'$'.$compra->importe.'.00',1,0,'L',true);
				Fpdf::Ln();
		////   Tabla Footer Fin
		///////////Comentario Inicio
			Fpdf::Cell(180,20,'Comentarios: '.utf8_decode($compra->observaciones),0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Compra'.$compra->id.'_'.$compra->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Compra'.$compra->id.'_'.$compra->fecha.'.pdf'), 200,$headers);
        
		
	}
	public function productosPdf($categoria)
	{
			
			Fpdf::AddPage();
			$altura=Fpdf::GetPageHeight();
		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Lista de productos',0	,0,'C'); 
			
		
		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			Fpdf::Ln();
			Fpdf::SetFont('times','B',10);
			Fpdf::SetFillColor(200,220,255);
			Fpdf::Cell(5,6,'#',1,0,'C',true);
			Fpdf::Cell(35,6,'Producto',1,0,'C',true);
			Fpdf::SetFont('times','I',9);
				foreach (Unidad::all() as $unidad){
					Fpdf::Cell(20,6,utf8_decode($unidad->nombre),1,0,'C',true);
				}
				Fpdf::Cell(10,6,'Total',1,0,'C',true);
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',8);
			Fpdf::SetFillColor(229,229,229);
			if($categoria=="Todos"){
				$productos=Producto::orderBy('nombre', 'asc')->get();
			}else{
				$productos=Producto::where('categoria',$categoria)->orderBy('nombre', 'asc')->get();
			}
			foreach ( $productos as $key => $producto) {
				if($key%39==0 && $key!=0){
					Fpdf::SetFont('times','B',10);
					Fpdf::SetFillColor(200,220,255);
					Fpdf::Cell(5,6,'#',1,0,'C',true);
					Fpdf::Cell(35,6,'Producto',1,0,'C',true);
					Fpdf::SetFont('times','I',9);
						foreach (Unidad::all() as $unidad){
							Fpdf::Cell(20,6,utf8_decode($unidad->nombre),1,0,'C',true);
						}
						Fpdf::Cell(10,6,'Total',1,0,'C',true);
					Fpdf::Ln();
					Fpdf::SetFont('arial','I',8);
			      	Fpdf::SetFillColor(229,229,229);
				}
				if($key%2==0){
					Fpdf::Cell(5,6,$key+1,1,0,'C',true);
					Fpdf::Cell(35,6,utf8_decode($producto->nombre),1,0,'L',true);
					foreach ($producto->unidades as $pUnidad ) {
						Fpdf::Cell(20,6,$pUnidad->pivot->cantidad,1,0,'C',true);
					}
					Fpdf::Cell(10,6,utf8_decode($producto->stock),1,0,'C',true);
				}else{
					Fpdf::Cell(5,6,$key+1,1,0,'C');
					Fpdf::Cell(35,6,utf8_decode($producto->nombre),1,0,'L');
					foreach ($producto->unidades as $pUnidad ) {
						Fpdf::Cell(20,6,$pUnidad->pivot->cantidad,1,0,'C');
					}
					Fpdf::Cell(10,6,utf8_decode($producto->stock),1,0,'C');
				}
				
				Fpdf::Ln();


			}
			

		
			Fpdf::SetTitle('Productos'.'_'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Productos'.'_'.date('Y-m-d').'.pdf'), 200,$headers);
        
		
	}

	public function precioProveedoresPdf(Request $request){
			$totalProveedores=$request->input('totalProveedores');
			$ancho=140/$totalProveedores;
			Fpdf::AddPage();
			$altura=Fpdf::GetPageHeight();
	
		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Lista de precios por proveedor',0	,0,'C'); 
			
		
		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			Fpdf::Ln();
			Fpdf::SetFont('times','B',10);
			Fpdf::SetFillColor(200,220,255);
			Fpdf::Cell(5,6,'#',1,0,'C',true);
			Fpdf::Cell(40,6,'Producto',1,0,'C',true);
			Fpdf::SetFont('times','I',9);
				for($i=1;$i<=$totalProveedores;$i++){
					$proveedor=Proveedor::find($request->input('proveedor'.$i));
					Fpdf::Cell($ancho,6,utf8_decode($proveedor->iniciales),1,0,'C',true);
				
				}
				
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',8);
			Fpdf::SetFillColor(229,229,229);
			$key=0;
			foreach (Producto::orderBy('nombre', 'asc')->get() as $producto) {
				
				
				if($producto->proveedores()->count()>0){

					$key++;
					if($key%2==0){
						Fpdf::Cell(5,6,$key,1,0,'C',true);
						Fpdf::Cell(40,6,utf8_decode($producto->nombre),1,0,'L',true);

							for ($i=1; $i <=$totalProveedores; $i++) { //total productos
								if($producto->proveedores()->find($request->input('proveedor'.$i))){
									Fpdf::Cell($ancho,6,'$'.$producto->proveedores()->find($request->input('proveedor'.$i))->pivot->precio,1,0,'C',true);
								}else{
									Fpdf::Cell($ancho,6,' ',1,0,'C',true);

								}
							}
					}else{
						Fpdf::Cell(5,6,$key,1,0,'C');
						Fpdf::Cell(40,6,utf8_decode($producto->nombre),1,0,'L');
						
							for ($i=1; $i <=$totalProveedores; $i++) { //total productos
								if($producto->proveedores()->find($request->input('proveedor'.$i))){
									Fpdf::Cell($ancho,6,'$'.$producto->proveedores()->find($request->input('proveedor'.$i))->pivot->precio,1,0,'C');
								}else{
									Fpdf::Cell($ancho,6,' ',1,0,'C');
								}
							}
						
					}
					
					Fpdf::Ln();
					
				}
				if($key%39==0 && $key!=0){
					Fpdf::SetFont('times','B',10);
					Fpdf::SetFillColor(200,220,255);
					Fpdf::Cell(5,6,'#',1,0,'C',true);
					Fpdf::Cell(40,6,'Producto',1,0,'C',true);
					Fpdf::SetFont('times','I',9);
						for($i=1;$i<$totalProveedores+1;$i++){
							$proveedor=Proveedor::find($request->input('proveedor'.$i));
							Fpdf::Cell($ancho,6,utf8_decode($proveedor->iniciales),1,0,'C',true);						
						}
					Fpdf::Ln();
					Fpdf::SetFont('arial','I',8);
			      	Fpdf::SetFillColor(229,229,229);
			      	$key++;
				}


			}
			

		
			Fpdf::SetTitle('Relacion_precio_proveedor'.'_'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Relacion_precio_proveedor'.'_'.date('Y-m-d').'.pdf'), 200,$headers);

	}

	public function hojaControlPdf(Request $request){
			
			Fpdf::AddPage();
			$altura=Fpdf::GetPageHeight();
	
		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Hoja de control del paciente hemodializado',0	,0,'C'); 
			
		
		//////////////////times  14 normal fin		

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			
				
				
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',8);
			Fpdf::SetFillColor(229,229,229);
			
		

		
			Fpdf::SetTitle('Relacion_precio_proveedor'.'_'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Relacion_precio_proveedor'.'_'.date('Y-m-d').'.pdf'), 200,$headers);

	}
	public function entradaSalidaSuplementosPdf(Request $request){
			
			Fpdf::AddPage();
			$usuario=User::find($request->input('usuario'));
	
		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Entrada y Salida de Suplementos',0,0,'C'); 
			Fpdf::SetFont('times','I',12);
			Fpdf::ln(15);
			Fpdf::Cell(10);
			Fpdf::Cell(100,10,'Unidad:  '.utf8_decode($usuario->unidad->nombre),0,0,'L'); 
			Fpdf::Cell(60,10,'   '.utf8_decode($usuario->name),0,0,'L'); 
			Fpdf::ln();
			$cortes= Corte::all();
			$corte= $cortes->last();
			$productos=Producto::where('categoria','Suplemento')->get();
			foreach ($productos as $producto) {
			////////////////// tabla inicio
				$producto->stock_corte=$producto->unidades()->find($usuario->unidad->id)->pivot->stock_corte;
				$producto->TotalProducto=0;
				$producto->TotalProductoEntrada=0;
				$producto->TotalProductoCredito=0;
			}
			foreach (Registro::where('created_at','>=',$corte->updated_at)->where('user_id',$usuario->id)->where('tipo',1)->get() as $registro) {
			////////////////// tabla inicio
				foreach ($registro->productos as $key => $producto) {
					
					if($productos->find($producto->id)){
						$productos->find($producto->id)->TotalProductoEntrada+=$producto->pivot->cantidad;
					}
				}
				//$ventasEfectivo+=$venta->importe;
			}

			foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',1)->get() as $venta) {
			////////////////// tabla inicio
				foreach ($venta->productos as $key => $producto) {
					
						if($productos->find($producto->id)){
							$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
						}
				}
				//$ventasEfectivo+=$venta->importe;
			}
			foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('created_at','>=',$corte->updated_at)->where('estatus',2)->get() as $venta){		
				//// Tabla Cuerpo Fin
				foreach ($venta->productos as $key => $producto) {
					//Fpdf::Cell(25,6,$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad.'.00',1,0,'L'); //prueba
					
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					
				}
				//$ventasCredito+=$venta->importe;
			
			}	
			foreach ($productos as $producto) {
				Fpdf::SetFont('arial','I',12);
				Fpdf::SetFillColor(229,229,229);
				Fpdf::Cell(190,6,utf8_decode($producto->nombre),0,0,'C',true); 
				Fpdf::ln(7);
				Fpdf::Cell(60,10,'Stock :   '.$producto->stock_corte.' '.$producto->presentacion.'s',0,0,'L'); 
				Fpdf::Cell(60,10,'Entrada :   '.$producto->TotalProductoEntrada.' '.$producto->presentacion.'s',0,0,'L');
				Fpdf::Cell(60,10,'Total Entrada :   '.($producto->TotalProductoEntrada+$producto->stock_corte).' '.$producto->presentacion.'s',0,0,'L');
				Fpdf::ln(5);
				Fpdf::Cell(60,10,'ventas:   '.$producto->TotalProducto.' '.$producto->presentacion.'s',0,0,'L'); 
				Fpdf::Cell(60,10,'Ventas a credito:   '.$producto->TotalProductoCredito.' '.$producto->presentacion.'s',0,0,'L');
				Fpdf::Cell(60,10,'Total Salida :   '.($producto->TotalProductoCredito+$producto->TotalProducto).' '.$producto->presentacion.'s',0,0,'L');
				Fpdf::ln(5);
				Fpdf::Cell(120);
				Fpdf::Cell(60,10,'Nuevo Stock :   '.(($producto->TotalProductoEntrada+$producto->stock_corte)-($producto->TotalProductoCredito+$producto->TotalProducto)).' '.$producto->presentacion.'s',0,0,'L');
				Fpdf::ln(7);
				if(Fpdf::GetY()>250){
					Fpdf::AddPage();
				}
			}
			

		
		//////////////////times  14 normal fin		 

		////////////////// tabla inicio
			//// Tabla Cabecera Inicio
			
				
				
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',8);
			Fpdf::SetFillColor(229,229,229);
			
		

		
			Fpdf::SetTitle('Entrada_Salida_Suplementos'.'_'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Entrada_Salida_Suplementos'.'_'.date('Y-m-d').'.pdf'), 200,$headers);

	}

public function ventasTotalesCortePdf(Request $request)
{

	$usuario=User::find($request->input('id'));
	$productos=Producto::where('categoria','Suplemento')->get();	
	
		if(count($usuario->ventas)>0){
			Fpdf::AddPage();
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Ventas',0	,0,'C'); 
			Fpdf::Ln();

			Fpdf::SetFont('times','B',12);
			Fpdf::SetFillColor(250,220,255);
			Fpdf::Cell(190,6,utf8_decode($usuario->name),1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Suplementos',1,0,'C');
			$ventasEfectivo=0;
			$ventasCredito=0;
			$eritro120=0;
			$eritro1000=0;
			$ventro55=0;
			$eritro120Credito=0;
			$eritro1000Credito=0;
			$ventro55Credito=0;
			$totalCateter=0;
			$totalIngreso=0;
			$totalEgreso=0;

			foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',1)->get() as $venta) {
			////////////////// tabla inicio
				foreach ($venta->productos as $key => $producto) {
					if($producto->id==70 && $producto->pivot->precio==166.66){
						$eritro1000+=($producto->pivot->cantidad/6);
					}
					elseif($producto->id==70 && $producto->pivot->precio==120){
						$eritro120+=$producto->pivot->cantidad;
					}
					elseif($producto->id==70 && $producto->pivot->precio==200){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==55){
						$ventro55+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==75){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}
					elseif($producto->id!=70 || $producto->id!=102){
						if($productos->find($producto->id)){
							$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
						}
						
					}
				}
				//$ventasEfectivo+=$venta->importe;
			}
			foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',2)->get() as $venta){		
				//// Tabla Cuerpo Fin
				foreach ($venta->productos as $key => $producto) {
					//Fpdf::Cell(25,6,$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad.'.00',1,0,'L'); //prueba
					if($producto->id==70 && $producto->pivot->precio==166.66){
						$eritro1000Credito+=($producto->pivot->cantidad/6);
					}
					elseif($producto->id==70 && $producto->pivot->precio==120){
						$eritro120Credito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==70 && $producto->pivot->precio==200){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==55){
						$ventro55Credito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==75){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					elseif($producto->id!=70 || $producto->id!=102){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					
				}
				//$ventasCredito+=$venta->importe;
			
			}
			Fpdf::SetFillColor(200,220,255);
			Fpdf::Ln();
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(40,6,'Producto',1,0,'C',true);
			Fpdf::Cell(30,6,'Precio',1,0,'C',true);
			Fpdf::Cell(30,6,'Can. Efectivo',1,0,'C',true);
			Fpdf::Cell(30,6,'Can. Credito',1,0,'C',true);
			Fpdf::Cell(30,6,'Total Efectivo',1,0,'C',true);
			Fpdf::Cell(30,6,'Total Credito',1,0,'C',true);
			Fpdf::Ln();
					
			Fpdf::SetFont('arial','I',8);
			foreach ($productos as $producto){
				if($producto->TotalProducto>0){



					Fpdf::Cell(40,5,$producto->nombre,1,0,'C');
					Fpdf::Cell(30,5,'$'.$producto->precio_venta,1,0,'C');
					if($producto->TotalProducto==1)
						Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion,1,0,'C');
					else{
						if($producto->TotalProducto==0)
							$producto->TotalProducto=0;
						Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion.'s',1,0,'C');
					}
					if($producto->TotalProductoCredito==1)
						Fpdf::Cell(30,5,$producto->TotalProductoCredito.' '.$producto->presentacion,1,0,'C');
					else{
						if($producto->TotalProductoCredito==0)
							$producto->TotalProductoCredito=0;
						Fpdf::Cell(30,5,$producto->TotalProductoCredito.' '.$producto->presentacion.'s',1,0,'C');
					}
					Fpdf::Cell(30,5,'$'.($producto->precio_venta*$producto->TotalProducto),1,0,'C');
					Fpdf::Cell(30,5,'$'.($producto->precio_venta*$producto->TotalProductoCredito),1,0,'C');
					Fpdf::Ln();
					$ventasEfectivo+=($producto->precio_venta*$producto->TotalProducto);
					$ventasCredito+=($producto->precio_venta*$producto->TotalProductoCredito);
				}
			}
			if($eritro1000>0){
				Fpdf::Cell(40,5,'Eritropoyetina 4000 (6 Piezas)',1,0,'C');
				Fpdf::Cell(30,5,'$1000',1,0,'C');
				if($eritro1000==1)
					Fpdf::Cell(30,5,$eritro1000.' Caja',1,0,'C');
				else
					Fpdf::Cell(30,5,$eritro1000.' Cajas',1,0,'C');
				if($eritro1000Credito==1)
					Fpdf::Cell(30,5,$eritro1000Credito.' Caja',1,0,'C');
				else
					Fpdf::Cell(30,5,$eritro1000Credito.' Cajas',1,0,'C');
				Fpdf::Cell(30,5,'$'.($eritro1000*1000),1,0,'C');
				Fpdf::Cell(30,5,'$'.($eritro1000Credito*1000),1,0,'C');
				Fpdf::Ln();
			}
			if($eritro120>0){
				Fpdf::Cell(40,5,'Eritropoyetina 4000 (1 Piezas)',1,0,'C');
				Fpdf::Cell(30,5,'$120',1,0,'C');
				if($eritro120==1)
					Fpdf::Cell(30,5,$eritro120.' Pieza',1,0,'C');
				else
					Fpdf::Cell(30,5,$eritro120.' Piezas',1,0,'C');
				if($eritro120Credito==1)
					Fpdf::Cell(30,5,$eritro120Credito.' Pieza',1,0,'C');
				else
					Fpdf::Cell(30,5,$eritro120Credito.' Piezas',1,0,'C');
				Fpdf::Cell(30,5,'$'.($eritro120*120),1,0,'C');
				Fpdf::Cell(30,5,'$'.($eritro120Credito*120),1,0,'C');
				Fpdf::Ln();
			}
			if($ventro55>0){
				Fpdf::Cell(40,5,'Ventro paciente',1,0,'C');
				Fpdf::Cell(30,5,'$55',1,0,'C');
				if($ventro55==1)
					Fpdf::Cell(30,5,$ventro55.' Caja',1,0,'C');
				else
					Fpdf::Cell(30,5,$ventro55.' Cajas',1,0,'C');
				if($ventro55Credito==1)
					Fpdf::Cell(30,5,$ventro55Credito.' Caja',1,0,'C');
				else
					Fpdf::Cell(30,5,$ventro55Credito.' Cajas',1,0,'C');
				Fpdf::Cell(30,5,'$'.($ventro55*55),1,0,'C');
				Fpdf::Cell(30,5,'$'.($ventro55Credito*55),1,0,'C');
				Fpdf::Ln();
			}
			Fpdf::Cell(100);
			$ventasEfectivo+=($eritro1000*1000)+($eritro120*120)+($ventro55*55);
			$ventasCredito+=($eritro1000Credito*1000)+($eritro120Credito*120)+($ventro55Credito*55);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Totales',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$ventasEfectivo,1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$ventasCredito,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Cateteres',1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(20,5,'Fecha',1,0,'C',true);
			Fpdf::Cell(30,5,'Cliente',1,0,'C',true);
			Fpdf::Cell(30,5,'Producto',1,0,'C',true);
			Fpdf::Cell(90,5,'Comentarios',1,0,'C',true);
			Fpdf::Cell(20,5,'Importe',1,0,'C',true);
			Fpdf::SetFont('arial','I',8);
			foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',1)->get() as $venta){
				foreach ($venta->productos as $producto) {
					if(strstr($producto->nombre,'Cat')){
						Fpdf::Ln();
						Fpdf::Cell(20,5,$venta->fecha,1,0,'C');
						Fpdf::Cell(30,5,utf8_decode($venta->cliente),1,0,'C');
						Fpdf::Cell(30,5,utf8_decode($producto->nombre),1,0,'C');						
						Fpdf::Cell(90,5,utf8_decode($venta->observaciones),1,0,'C');
						Fpdf::Cell(20,5,'$'.$producto->pivot->precio,1,0,'C');
						$totalCateter+=$producto->pivot->precio;
					}
				}
				
			}
			Fpdf::Ln();
			Fpdf::Cell(140);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Total:',1,0,'C',true);
			Fpdf::Cell(20,5,'$'.$totalCateter,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Ingresos ',1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(30,5,'Fecha',1,0,'C',true);
			Fpdf::Cell(130,5,'Concepto',1,0,'C',true);
			Fpdf::Cell(30,5,'Importe',1,0,'C',true);
			Fpdf::SetFont('arial','I',8);
			foreach (Ingreso::where('corte',0)->where('user_id',$usuario->id)->get() as $ingreso){
				Fpdf::Ln();
				Fpdf::Cell(30,5,$ingreso->fecha,1,0,'C');
				Fpdf::Cell(130,5,$ingreso->concepto,1,0,'C');
				Fpdf::Cell(30,5,'$'.$ingreso->importe,1,0,'C');
				$totalIngreso+=$ingreso->importe;
			}
			Fpdf::Ln();
			Fpdf::Cell(130);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Total:',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$totalIngreso,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Egresos ',1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(30,5,'Fecha',1,0,'C',true);
			Fpdf::Cell(130,5,'Concepto',1,0,'C',true);
			Fpdf::Cell(30,5,'Importe',1,0,'C',true);
			Fpdf::SetFont('arial','I',8);
			foreach (Egreso::where('corte',0)->where('user_id',$usuario->id)->get() as $egreso){
				Fpdf::Ln();
				Fpdf::Cell(30,5,$egreso->fecha,1,0,'C');
				Fpdf::Cell(130,5,$egreso->concepto,1,0,'C');
				Fpdf::Cell(30,5,'$'.$egreso->importe,1,0,'C');
				$totalEgreso+=$egreso->importe;
			}
			Fpdf::Ln();
			Fpdf::Cell(130);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Total:',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$totalEgreso,1,0,'C',true);
			Fpdf::Ln();

			Fpdf::Ln();
			Fpdf::Cell(50);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(110,5,'Total en efectivo a entregar: ',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.($ventasEfectivo+$totalCateter+$totalIngreso-$totalEgreso),1,0,'C',true);
			Fpdf::Ln();


		}

	

	Fpdf::SetTitle('Ventas totales del corte '.date('Y-m-d'));
	$headers=['Content-Type'=>'application/pdf'];
	return Response::make(Fpdf::Output('I','Ventas totales del corte '.date('Y-m-d').'.pdf'), 200,$headers);
}
	public function ventasTotalesCortePdfReimpresion(Request $request)
{

	$usuario=User::find($request->input('id'));
	$productos=Producto::where('categoria','Suplemento')->get();	
	$corte=Corte::find($request->input('corte'));
	$fechaInicioCorte=$corte->ventas[0]->created_at;
	$fechaFinCorte=$corte->created_at;
			Fpdf::AddPage();
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Ventas',0	,0,'C'); 
			Fpdf::Ln();

			Fpdf::SetFont('times','B',12);
			Fpdf::SetFillColor(250,220,255);
			Fpdf::Cell(190,6,utf8_decode($usuario->name).' Del ' .$fechaInicioCorte.' Al '.$fechaFinCorte,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Suplementos',1,0,'C');
			$ventasEfectivo=0;
			$ventasCredito=0;
			$eritro120=0;
			$eritro1000=0;
			$ventro55=0;
			$eritro120Credito=0;
			$eritro1000Credito=0;
			$ventro55Credito=0;
			$totalCateter=0;
			$totalIngreso=0;
			$totalEgreso=0;

			foreach ($corte->ventas as $venta) {
			////////////////// tabla inicio
				foreach ($venta->productos as $key => $producto) {
					if($producto->id==70 && $producto->pivot->precio==166.66){
						$eritro1000+=($producto->pivot->cantidad/6);
					}
					elseif($producto->id==70 && $producto->pivot->precio==120){
						$eritro120+=$producto->pivot->cantidad;
					}
					elseif($producto->id==70 && $producto->pivot->precio==200){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==55){
						$ventro55+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==75){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}
					elseif($producto->id!=70 || $producto->id!=102){
						if($productos->find($producto->id)){
							$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
						}
						
					}
				}
				//$ventasEfectivo+=$venta->importe;
			}
			foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',2)->get() as $venta){		
				//// Tabla Cuerpo Fin
				foreach ($venta->productos as $key => $producto) {
					//Fpdf::Cell(25,6,$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad.'.00',1,0,'L'); //prueba
					if($producto->id==70 && $producto->pivot->precio==166.66){
						$eritro1000Credito+=($producto->pivot->cantidad/6);
					}
					elseif($producto->id==70 && $producto->pivot->precio==120){
						$eritro120Credito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==70 && $producto->pivot->precio==200){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==55){
						$ventro55Credito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==75){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					elseif($producto->id!=70 || $producto->id!=102){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					
				}
				//$ventasCredito+=$venta->importe;
			
			}
			Fpdf::SetFillColor(200,220,255);
			Fpdf::Ln();
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(40,6,'Producto',1,0,'C',true);
			Fpdf::Cell(30,6,'Precio',1,0,'C',true);
			Fpdf::Cell(30,6,'Can. Efectivo',1,0,'C',true);
			Fpdf::Cell(30,6,'Can. Credito',1,0,'C',true);
			Fpdf::Cell(30,6,'Total Efectivo',1,0,'C',true);
			Fpdf::Cell(30,6,'Total Credito',1,0,'C',true);
			Fpdf::Ln();
					
			Fpdf::SetFont('arial','I',8);
			foreach ($productos as $producto){
				if($producto->TotalProducto>0){
					Fpdf::Cell(40,5,$producto->nombre,1,0,'C');
					Fpdf::Cell(30,5,'$'.$producto->precio_venta,1,0,'C');
					if($producto->TotalProducto==1)
						Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion,1,0,'C');
					else{
						if($producto->TotalProducto==0)
							$producto->TotalProducto=0;
						Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion.'s',1,0,'C');
					}
					if($producto->TotalProductoCredito==1)
						Fpdf::Cell(30,5,$producto->TotalProductoCredito.' '.$producto->presentacion,1,0,'C');
					else{
						if($producto->TotalProductoCredito==0)
							$producto->TotalProductoCredito=0;
						Fpdf::Cell(30,5,$producto->TotalProductoCredito.' '.$producto->presentacion.'s',1,0,'C');
					}
					Fpdf::Cell(30,5,'$'.($producto->precio_venta*$producto->TotalProducto),1,0,'C');
					Fpdf::Cell(30,5,'$'.($producto->precio_venta*$producto->TotalProductoCredito),1,0,'C');
					Fpdf::Ln();
					$ventasEfectivo+=($producto->precio_venta*$producto->TotalProducto);
					$ventasCredito+=($producto->precio_venta*$producto->TotalProductoCredito);
				}
				
			}
			Fpdf::Cell(40,5,'Eritropoyetina 4000 (6 Piezas)',1,0,'C');
			Fpdf::Cell(30,5,'$1000',1,0,'C');
			if($eritro1000==1)
				Fpdf::Cell(30,5,$eritro1000.' Caja',1,0,'C');
			else
				Fpdf::Cell(30,5,$eritro1000.' Cajas',1,0,'C');
			if($eritro1000Credito==1)
				Fpdf::Cell(30,5,$eritro1000Credito.' Caja',1,0,'C');
			else
				Fpdf::Cell(30,5,$eritro1000Credito.' Cajas',1,0,'C');
			Fpdf::Cell(30,5,'$'.($eritro1000*1000),1,0,'C');
			Fpdf::Cell(30,5,'$'.($eritro1000Credito*1000),1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(40,5,'Eritropoyetina 4000 (1 Piezas)',1,0,'C');
			Fpdf::Cell(30,5,'$120',1,0,'C');
			if($eritro120==1)
				Fpdf::Cell(30,5,$eritro120.' Pieza',1,0,'C');
			else
				Fpdf::Cell(30,5,$eritro120.' Piezas',1,0,'C');
			if($eritro120Credito==1)
				Fpdf::Cell(30,5,$eritro120Credito.' Pieza',1,0,'C');
			else
				Fpdf::Cell(30,5,$eritro120Credito.' Piezas',1,0,'C');
			Fpdf::Cell(30,5,'$'.($eritro120*120),1,0,'C');
			Fpdf::Cell(30,5,'$'.($eritro120Credito*120),1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(40,5,'Ventro paciente',1,0,'C');
			Fpdf::Cell(30,5,'$55',1,0,'C');
			if($ventro55==1)
				Fpdf::Cell(30,5,$ventro55.' Caja',1,0,'C');
			else
				Fpdf::Cell(30,5,$ventro55.' Cajas',1,0,'C');
			if($ventro55Credito==1)
				Fpdf::Cell(30,5,$ventro55Credito.' Caja',1,0,'C');
			else
				Fpdf::Cell(30,5,$ventro55Credito.' Cajas',1,0,'C');
			Fpdf::Cell(30,5,'$'.($ventro55*55),1,0,'C');
			Fpdf::Cell(30,5,'$'.($ventro55Credito*55),1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(100);
			$ventasEfectivo+=($eritro1000*1000)+($eritro120*120)+($ventro55*55);
			$ventasCredito+=($eritro1000Credito*1000)+($eritro120Credito*120)+($ventro55Credito*55);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Totales',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$ventasEfectivo,1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$ventasCredito,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Cateteres',1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(20,5,'Fecha',1,0,'C',true);
			Fpdf::Cell(30,5,'Cliente',1,0,'C',true);
			Fpdf::Cell(30,5,'Producto',1,0,'C',true);
			Fpdf::Cell(90,5,'Comentarios',1,0,'C',true);
			Fpdf::Cell(20,5,'Importe',1,0,'C',true);
			Fpdf::SetFont('arial','I',8);
			foreach ($corte->ventas as $venta){
				foreach ($venta->productos as $producto) {
					if(strstr($producto->nombre,'Cat')){
						Fpdf::Ln();
						Fpdf::Cell(20,5,$venta->fecha,1,0,'C');
						Fpdf::Cell(30,5,utf8_decode($venta->cliente),1,0,'C');
						Fpdf::Cell(30,5,utf8_decode($producto->nombre),1,0,'C');						
						Fpdf::Cell(90,5,utf8_decode($venta->observaciones),1,0,'C');
						Fpdf::Cell(20,5,'$'.$producto->pivot->precio,1,0,'C');
						$totalCateter+=$producto->pivot->precio;
					}
				}
				
			}
			Fpdf::Ln();
			Fpdf::Cell(140);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Total:',1,0,'C',true);
			Fpdf::Cell(20,5,'$'.$totalCateter,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Ingresos ',1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(30,5,'Fecha',1,0,'C',true);
			Fpdf::Cell(130,5,'Concepto',1,0,'C',true);
			Fpdf::Cell(30,5,'Importe',1,0,'C',true);
			Fpdf::SetFont('arial','I',8);
			foreach (Ingreso::where('created_at','>=',$fechaInicioCorte)->where('created_at','<=',$fechaFinCorte)->where('user_id',$usuario->id)->get() as $ingreso){
				Fpdf::Ln();
				Fpdf::Cell(30,5,$ingreso->fecha,1,0,'C');
				Fpdf::Cell(130,5,$ingreso->concepto,1,0,'C');
				Fpdf::Cell(30,5,'$'.$ingreso->importe,1,0,'C');
				$totalIngreso+=$ingreso->importe;
			}
			Fpdf::Ln();
			Fpdf::Cell(130);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Total:',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$totalIngreso,1,0,'C',true);
			Fpdf::Ln();
			Fpdf::Ln();
			Fpdf::Cell(190,6,'Egresos ',1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(30,5,'Fecha',1,0,'C',true);
			Fpdf::Cell(130,5,'Concepto',1,0,'C',true);
			Fpdf::Cell(30,5,'Importe',1,0,'C',true);
			Fpdf::SetFont('arial','I',8);
			foreach (Egreso::where('created_at','>=',$fechaInicioCorte)->where('created_at','<=',$fechaFinCorte)->where('user_id',$usuario->id)->get() as $egreso){
				Fpdf::Ln();
				Fpdf::Cell(30,5,$egreso->fecha,1,0,'C');
				Fpdf::Cell(130,5,$egreso->concepto,1,0,'C');
				Fpdf::Cell(30,5,'$'.$egreso->importe,1,0,'C');
				$totalEgreso+=$egreso->importe;
			}
			Fpdf::Ln();
			Fpdf::Cell(130);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(30,5,'Total:',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.$totalEgreso,1,0,'C',true);
			Fpdf::Ln();

			Fpdf::Ln();
			Fpdf::Cell(50);
			Fpdf::SetFont('arial','B',10);
			Fpdf::Cell(110,5,'Total en efectivo a entregar: ',1,0,'C',true);
			Fpdf::Cell(30,5,'$'.($ventasEfectivo+$totalCateter+$totalIngreso-$totalEgreso),1,0,'C',true);
			Fpdf::Ln();


		

	

	Fpdf::SetTitle('Ventas totales del corte '.date('Y-m-d'));
	$headers=['Content-Type'=>'application/pdf'];
	return Response::make(Fpdf::Output('I','Ventas totales del corte '.date('Y-m-d').'.pdf'), 200,$headers);
}
	public function reporteVentasPdf(Request $request) 
	{		
		$fechas=$request->input('fechas');
		$fechaInicio=substr($fechas,6,4).'/'.substr($fechas,0,5);
		$fechaFin=substr($fechas,-4,4).'/'.substr($fechas,-10,5);
		$header = ['#', 'Nombre','Cantidad','Precio U.', 'Precio T.'];
		Fpdf::AddPage();
		//return $request->all();
			//////////////////times  14 normal inicio
		//Tipo de documento
		Fpdf::ln(-20);
		Fpdf::SetFont('times','I',16);
		Fpdf::Cell(60);
		Fpdf::Cell(60,20,'Reporte de ventas',0	,0,'C'); 
		Fpdf::ln(10);
		Fpdf::SetFont('times','I',12);
			//////////////////times  14 normal fin	
		//return$fechaInicio.'-------------'.$fechaFin;
		$productos=Producto::where('categoria','Suplemento')->get();
		if($request->input('unidad')==0){
			Fpdf::Cell(180,10,'Todas las unidades',0,0,'C'); 
			$ventas=Venta::where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->get();	
		}else{
			$unidad=User::find($request->input('unidad'))->unidad->nombre;
			Fpdf::Cell(180,10,'Unidad: '.utf8_decode($unidad),0	,0,'C'); 
			$ventas=Venta::where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('user_id',$request->input('unidad'))->get();
		}
		
		$ventasEfectivo=0;
		$ventasCredito=0;
		$eritro120=0;
		$eritro1000=0;
		$ventro55=0;
		$eritro120Credito=0;
		$eritro1000Credito=0;
		$ventro55Credito=0;

		foreach($ventas as $venta) {
			if($venta->estatus=1){
				foreach ($venta->productos as $key => $producto) {
					
					if($producto->id==70 && $producto->pivot->precio==166.66){
						$eritro1000+=($producto->pivot->cantidad/6);
					}
					elseif($producto->id==70 && $producto->pivot->precio==120){
						$eritro120+=$producto->pivot->cantidad;
					}
					elseif($producto->id==70 && $producto->pivot->precio==200){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==55){
						$ventro55+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==75){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}
					elseif($producto->id!=70 || $producto->id!=102){
						$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					}	
				}
				//$ventasEfectivo+=$venta->importe;
			}
			elseif($venta->estatus=2){
				foreach ($venta->productos as $key => $producto) {
					if($producto->id==70 && $producto->pivot->precio==166.66){

						$eritro1000Credito+=($producto->pivot->cantidad/6);
					}
					elseif($producto->id==70 && $producto->pivot->precio==120){
						$eritro120Credito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==70 && $producto->pivot->precio==200){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==55){
						$ventro55Credito+=$producto->pivot->cantidad;
					}
					elseif($producto->id==102 && $producto->pivot->precio==75){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					elseif($producto->id!=70 || $producto->id!=102){
						$productos->find($producto->id)->TotalProductoCredito+=$producto->pivot->cantidad;
					}
					
				}
			}//termina elsif
		}
			Fpdf::SetFillColor(200,220,255);
				Fpdf::Ln();
					Fpdf::SetFont('arial','B',10);
					Fpdf::Cell(40,6,'Producto',1,0,'C',true);
					Fpdf::Cell(30,6,'Precio',1,0,'C',true);
					Fpdf::Cell(30,6,'Can. Efectivo',1,0,'C',true);
					Fpdf::Cell(30,6,'Can. Credito',1,0,'C',true);
					Fpdf::Cell(30,6,'Total Efectivo',1,0,'C',true);
					Fpdf::Cell(30,6,'Total Credito',1,0,'C',true);
					Fpdf::Ln();
					
				Fpdf::SetFont('arial','I',8);
				foreach ($productos as $producto) {
					Fpdf::Cell(40,5,$producto->nombre,1,0,'L');
					Fpdf::Cell(30,5,'$'.$producto->precio_venta,1,0,'C');
					if($producto->TotalProducto==1)
					Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion,1,0,'C');
					else{
						if($producto->TotalProducto==0)
							$producto->TotalProducto=0;
						Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion.'s',1,0,'C');
					}
					if($producto->TotalProductoCredito==1)
					Fpdf::Cell(30,5,$producto->TotalProductoCredito.' '.$producto->presentacion,1,0,'C');
					else{
						if($producto->TotalProductoCredito==0)
							$producto->TotalProductoCredito=0;
						Fpdf::Cell(30,5,$producto->TotalProductoCredito.' '.$producto->presentacion.'s',1,0,'C');
					}
					Fpdf::Cell(30,5,'$'.($producto->precio_venta*$producto->TotalProducto),1,0,'C');
					Fpdf::Cell(30,5,'$'.($producto->precio_venta*$producto->TotalProductoCredito),1,0,'C');
					Fpdf::Ln();
					// $producto->TotalProducto=0;
					// $producto->TotalProductoCredito=0;

					$ventasEfectivo+=($producto->precio_venta*$producto->TotalProducto);
					$ventasCredito+=($producto->precio_venta*$producto->TotalProductoCredito);
				}
					Fpdf::Cell(40,5,'Eritropoyetina 4000 (6 Piezas)',1,0,'L');
					Fpdf::Cell(30,5,'$1000',1,0,'C');
					if($eritro1000==1)
					Fpdf::Cell(30,5,$eritro1000.' Caja',1,0,'C');
					else
						Fpdf::Cell(30,5,$eritro1000.' Cajas',1,0,'C');
					if($eritro1000Credito==1)
						Fpdf::Cell(30,5,$eritro1000Credito.' Caja',1,0,'C');
					else
						Fpdf::Cell(30,5,$eritro1000Credito.' Cajas',1,0,'C');
					Fpdf::Cell(30,5,'$'.($eritro1000*1000),1,0,'C');
					Fpdf::Cell(30,5,'$'.($eritro1000Credito*1000),1,0,'C');
					Fpdf::Ln();
					Fpdf::Cell(40,5,'Eritropoyetina 4000 (1 Piezas)',1,0,'L');
					Fpdf::Cell(30,5,'$120',1,0,'C');
					if($eritro120==1)
					Fpdf::Cell(30,5,$eritro120.' Pieza',1,0,'C');
					else
						Fpdf::Cell(30,5,$eritro120.' Piezas',1,0,'C');
					if($eritro120Credito==1)
						Fpdf::Cell(30,5,$eritro120Credito.' Pieza',1,0,'C');
					else
						Fpdf::Cell(30,5,$eritro120Credito.' Piezas',1,0,'C');
					Fpdf::Cell(30,5,'$'.($eritro120*120),1,0,'C');
					Fpdf::Cell(30,5,'$'.($eritro120Credito*120),1,0,'C');
					Fpdf::Ln();
					Fpdf::Cell(40,5,'Ventro paciente',1,0,'L');
					Fpdf::Cell(30,5,'$55',1,0,'C');
					if($ventro55==1)
					Fpdf::Cell(30,5,$ventro55.' Caja',1,0,'C');
					else
						Fpdf::Cell(30,5,$ventro55.' Cajas',1,0,'C');
					if($ventro55Credito==1)
						Fpdf::Cell(30,5,$ventro55Credito.' Caja',1,0,'C');
					else
						Fpdf::Cell(30,5,$ventro55Credito.' Cajas',1,0,'C');
					Fpdf::Cell(30,5,'$'.($ventro55*55),1,0,'C');
					Fpdf::Cell(30,5,'$'.($ventro55Credito*55),1,0,'C');
					$ventasEfectivo+=($eritro1000*1000);
					$ventasCredito+=($eritro1000Credito*1000);
					$ventasEfectivo+=($eritro120*120);
					$ventasCredito+=($eritro120Credito*120);
					$ventasEfectivo+=($ventro55*55);
					$ventasCredito+=($ventro55Credito*55);
					Fpdf::Ln();
					Fpdf::Cell(100);
					Fpdf::SetFont('arial','B',10);
					Fpdf::Cell(30,5,'Totales',1,0,'C',true);
					Fpdf::Cell(30,5,'$'.$ventasEfectivo,1,0,'C',true);
					Fpdf::Cell(30,5,'$'.$ventasCredito,1,0,'C',true);

			Fpdf::SetTitle('Ventas totales del corte '.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Ventas totales del corte '.date('Y-m-d').'.pdf'), 200,$headers);
        
		
}

public function reciboPdf($id){
			Fpdf::AddPage();
			$recibo=Recibo::find($id);
			$altura=Fpdf::GetPageHeight();

		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-25);
			// Fpdf::SetFillColor(100,100,100);
			// Fpdf::line(0,$altura/3,220,$altura/3);
			// Fpdf::line(0,($altura/3)*2,220,($altura/3)*2);
			Fpdf::SetFillColor(255,255,255);
			Fpdf::Rect(10,10,190,20,'F');
			Fpdf::SetFont('times','B',16);
			Fpdf::Cell(60);
			
			//Fpdf::Image('../public/img/logo_2.png',20,11,20,0,'PNG');
			Fpdf::Image('img/logo_2.png',20,11,20,0,'PNG');
			////////////////////////////////
			Fpdf::Ln();
			Fpdf::Cell(65);

			Fpdf::Cell(60,10,utf8_decode('Recibo Original'),1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(65);
			Fpdf::SetFont('Helvetica','B',14);
			Fpdf::Cell(60,10,utf8_decode($recibo->unidad->nombre),0,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(5);
			/////Fecha
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(60,10,'Fecha:______________',0,0,'L');
			Fpdf::Cell(-40);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(40,10,$recibo->fecha,0,0,'L');
			///// Temmina Fecha
			if($recibo->folio>0){
				Fpdf::SetFont('times','B',14);
				Fpdf::Cell(60,10,'Folio Anterior:________',0,0,'C');
				Fpdf::Cell(-23);
				Fpdf::SetFont('Courier','I',12);
				Fpdf::Cell(23,10,$recibo->folio,0,0,'L');
			}else{
				Fpdf::Cell(60);
			}
			/////Folio
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(60,10,'Folio:_________',0,0,'R');
			Fpdf::Cell(-23);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(23,10,$recibo->id,0,0,'L');

			/////Termina Folio
			/////Nombre
			Fpdf::Ln();
			Fpdf::Cell(5);
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(180,10,'Nombre del paciente:____________________________________',0,0,'L');
			Fpdf::Cell(-130);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(60,10,$recibo->paciente->nombre,0,0,'L');
			// ////Termina Nombre
			// //// Pago
			Fpdf::Ln();
			Fpdf::Cell(5);
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(90,10,'Metodo de pago: ',0,0,'L');
			Fpdf::SetFont('Courier','I',12);	
			Fpdf::Cell(-50);
			Fpdf::Cell(50,10,utf8_decode($recibo->tipo_pago),0,0,'L');
			if($recibo->tipo_pago=='Efectivo' || $recibo->tipo_pago=='Credito' || $recibo->tipo_pago=='Hospital'){
				Fpdf::SetFont('times','B',14);
				Fpdf::Cell(90,10,'Cantidad:__________ ',0,0,'R');
				Fpdf::SetFont('Courier','I',12);	
				Fpdf::Cell(-27);
				Fpdf::Cell(27,10,'$'.number_format($recibo->cantidad,2),0,0,'L');
			}
			Fpdf::Ln(5);
			// ////Termina Pago
			Fpdf::Ln(20);
			Fpdf::Cell(90,10,'____________________________ ',0,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(90,10,'Nombre y Firma ',0,0,'C');
			Fpdf::Ln(-25);
			Fpdf::Cell(90);
			Fpdf::SetFont('Courier','B',14);
			Fpdf::Cell(90,30,'Sello del Hospital ',1,0,'C');
			
			Fpdf::Ln(-50);
			Fpdf::Cell(190,85,'',1,0,'C');
			///////////////////////////////// Termina Recibo Original
			Fpdf::Ln(5);
			/////////////////////////////////////////Copia Recibo

			//Fpdf::Image('../public/img/logo_2.png',20,101,20,0,'PNG');
			Fpdf::Image('img/logo_2.png',20,101,20,0,'PNG');
			Fpdf::SetFont('times','B',16);
			Fpdf::Ln();
			Fpdf::Cell(65);

			Fpdf::Cell(60,10,utf8_decode('Recibo Copia'),1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(65);
			Fpdf::SetFont('Helvetica','B',14);
			Fpdf::Cell(60,10,utf8_decode($recibo->unidad->nombre),0,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(5);
			/////Fecha
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(60,10,'Fecha:______________',0,0,'L');
			Fpdf::Cell(-40);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(40,10,$recibo->fecha,0,0,'L');
			///// Temmina Fecha
			if($recibo->folio>0){
				Fpdf::SetFont('times','B',14);
				Fpdf::Cell(60,10,'Folio Anterior:________',0,0,'C');
				Fpdf::Cell(-23);
				Fpdf::SetFont('Courier','I',12);
				Fpdf::Cell(23,10,$recibo->folio,0,0,'L');
			}else{
				Fpdf::Cell(60);
			}
			/////Folio
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(60,10,'Folio:_________',0,0,'R');
			Fpdf::Cell(-23);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(23,10,$recibo->id,0,0,'L');

			/////Termina Folio
			/////Nombre
			Fpdf::Ln();
			Fpdf::Cell(5);
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(180,10,'Nombre del paciente:____________________________________',0,0,'L');
			Fpdf::Cell(-130);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(60,10,$recibo->paciente->nombre,0,0,'L');
			
			// ////Termina Nombre
			// //// Pago
			Fpdf::Ln();
			Fpdf::Cell(5);
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(90,10,'Metodo de pago: ',0,0,'L');
			Fpdf::SetFont('Courier','I',12);	
			Fpdf::Cell(-50);
			Fpdf::Cell(50,10,utf8_decode($recibo->tipo_pago),0,0,'L');
			if($recibo->tipo_pago=='Efectivo' || $recibo->tipo_pago=='Credito' || $recibo->tipo_pago=='Hospital'){
				Fpdf::SetFont('times','B',14);
				Fpdf::Cell(90,10,'Cantidad:__________ ',0,0,'R');
				Fpdf::SetFont('Courier','I',12);	
				Fpdf::Cell(-27);
				Fpdf::Cell(27,10,'$'.number_format($recibo->cantidad,2),0,0,'L');
			}

			Fpdf::Ln(5);
			// ////Termina Pago
			Fpdf::Ln(20);
			Fpdf::Cell(90,10,'____________________________ ',0,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(90,10,'Nombre y Firma ',0,0,'C');
			Fpdf::Ln(-25);
			Fpdf::Cell(90);
			Fpdf::SetFont('Courier','B',14);
			Fpdf::Cell(90,30,'Sello del Hospital ',1,0,'C');
			
			Fpdf::Ln(-50);
			Fpdf::Cell(190,85,'',1,0,'C');
			//////////////////////////////// Termina Copia Recibo
			
			if($recibo->tipo_pago=="Hospital" || $recibo->tipo_pago=="Credito" || $recibo->tipo_pago=="Cargo a habitación"){
			Fpdf::Ln(5);
			///////////////////////////////////////// Copia Hospital

			//Fpdf::Image('../public/img/logo_2.png',20,191,20,0,'PNG');
			Fpdf::Image('img/logo_2.png',20,191,20,0,'PNG');
			Fpdf::SetFont('times','B',16);
			Fpdf::Ln();
			Fpdf::Cell(65);

			Fpdf::Cell(60,10,utf8_decode('Recibo Hospital'),1,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(65);
			Fpdf::SetFont('Helvetica','B',14);
			Fpdf::Cell(60,10,utf8_decode($recibo->unidad->nombre),0,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(5);
			/////Fecha
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(60,10,'Fecha:______________',0,0,'L');
			Fpdf::Cell(-40);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(40,10,$recibo->fecha,0,0,'L');
			///// Temmina Fecha
			if($recibo->folio>0){
				Fpdf::SetFont('times','B',14);
				Fpdf::Cell(60,10,'Folio Anterior:________',0,0,'C');
				Fpdf::Cell(-23);
				Fpdf::SetFont('Courier','I',12);
				Fpdf::Cell(23,10,$recibo->folio,0,0,'L');
			}else{
				Fpdf::Cell(60);
			}
			/////Folio
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(60,10,'Folio:_________',0,0,'R');
			Fpdf::Cell(-23);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(23,10,$recibo->id,0,0,'L');

			/////Termina Folio
			/////Nombre
			Fpdf::Ln();
			Fpdf::Cell(5);
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(180,10,'Nombre del paciente:____________________________________',0,0,'L');
			Fpdf::Cell(-130);
			Fpdf::SetFont('Courier','I',12);
			Fpdf::Cell(60,10,$recibo->paciente->nombre,0,0,'L');
			// ////Termina Nombre
			// //// Pago
			Fpdf::Ln();
			Fpdf::Cell(5);
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(90,10,'Metodo de pago: ',0,0,'L');
			Fpdf::SetFont('Courier','I',12);	
			Fpdf::Cell(-50);
			Fpdf::Cell(50,10,utf8_decode($recibo->tipo_pago),0,0,'L');
			Fpdf::SetFont('times','B',14);
			Fpdf::Cell(90,10,'Cantidad:__________ ',0,0,'R');
			Fpdf::SetFont('Courier','I',12);	
			Fpdf::Cell(-27);
			Fpdf::Cell(27,10,'$'.number_format($recibo->cantidad,2),0,0,'L');
			Fpdf::Ln(5);
			// ////Termina Pago
			Fpdf::Ln(20);
			Fpdf::Cell(90,10,'____________________________ ',0,0,'C');
			Fpdf::Ln();
			Fpdf::Cell(90,10,'Nombre y Firma ',0,0,'C');
			Fpdf::Ln(-25);
			Fpdf::Cell(90);
			Fpdf::SetFont('Courier','B',14);
			Fpdf::Cell(90,30,'Sello del Hospital ',1,0,'C');
			
			Fpdf::Ln(-50);
			Fpdf::Cell(190,85,'',1,0,'C');
			//////////////////////////////// Termina Copia recibo
		}
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			
		

		
			Fpdf::SetTitle('Recibo'.'_'.$recibo->nombre.' _'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Recibo'.'_'.$recibo->nombre.' _'.date('Y-m-d').'.pdf'), 200,$headers);
	}
	public function reporteRecibosPdf(Request $request){

		//return $request->all();
		Fpdf::AddPage();
		$fechas=$request->input('fechas');
		$fechaInicio=substr($fechas,6,4).'/'.substr($fechas,0,5);
		$fechaFin=substr($fechas,-4,4).'/'.substr($fechas,-10,5);
		$unidad=$request->input('unidad');
		$paciente=$request->input('paciente');
		$metodo=$request->input('metodoPago');

		
		if($unidad=='0'){
			if($paciente=='0'){
				if($metodo=='0'){
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->get();
					
				}else{
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('tipo_pago','like',$metodo.'%')->get();
				
				}
			}else{
				if($metodo=='0'){
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('paciente_id',$paciente)->get();
				}
				else{
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('paciente_id',$paciente)->where('tipo_pago','like',$metodo.'%')->get();
				}
			}
		}else{
			if($paciente=='0'){
				if($metodo=='0'){
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('unidad_id',$unidad)->get();
				}else{

					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('unidad_id',$unidad)->where('tipo_pago','like',$metodo.'%')->get();

				}
			}else{
				if($metodo=='0'){
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('unidad_id',$unidad)->where('paciente_id',$paciente)->get();
				}
				else{
					$recibos=Recibo::where('estatus',2)->where('fecha','>=',$fechaInicio)->where('fecha','<=',$fechaFin)->where('unidad_id',$unidad)->where('paciente_id',$paciente)->where('tipo_pago','like',$metodo.'%')->get();
				}
			}
		}
		

		Fpdf::ln(-20);
		Fpdf::SetFont('times','I',14);
		Fpdf::Cell(40);
		Fpdf::Cell(80,20,'Reporte recibos de '.$fechas,0	,0,'C'); 
		Fpdf::SetFont('times','B',14);
		if($unidad==0){

			Fpdf::Cell(60,20,'Todas las unidades',0	,0,'C'); 
		}else{
			Fpdf::Cell(60,20,utf8_decode(Unidad::find($unidad)->nombre),0	,0,'C'); 
		}
		Fpdf::ln();
		Fpdf::SetFont('Arial','B',12);

		Fpdf::SetFillColor(200,220,255);
		Fpdf::Cell(10,10,' # ',1	,0,'C',true);
		Fpdf::Cell(50,10,'Nombre',1	,0,'C',true);
		Fpdf::Cell(20,10,'Fecha',1	,0,'C',true);
		Fpdf::Cell(20,10,'Folio N.',1	,0,'C',true);
		Fpdf::Cell(20,10,'Folio A.',1	,0,'C',true);
		Fpdf::Cell(30,10,'Pago',1	,0,'C',true); 
		Fpdf::Cell(20,10,'Estado',1	,0,'C',true); 
		Fpdf::Cell(20,10,'Cantidad',1,0,'C',true); 
		Fpdf::Ln();
		Fpdf::SetFont('times','I',9);
		$totalReporte=0;
		Fpdf::SetFillColor(250,250,250);
		foreach ($recibos as $key => $recibo) {
			$totalReporte+=$recibo->cantidad;
			if($key%2==0){
				Fpdf::Cell(10,8,$key+1,1,0,'C');
				Fpdf::Cell(50,8,$recibo->paciente->nombre,1	,0,'L');
				Fpdf::Cell(20,8,$recibo->fecha,1,0,'C');
				Fpdf::Cell(20,8,$recibo->id,1,0,'C');
				Fpdf::Cell(20,8,$recibo->folio,1,0,'C');
				Fpdf::Cell(30,8,utf8_decode($recibo->tipo_pago),1,0,'L'); 
				if($recibo->estatus==1)
					Fpdf::Cell(20,8,'Emitido',1	,0,'C'); 
				elseif($recibo->estatus==2)
					Fpdf::Cell(20,8,'Pagado',1	,0,'C'); 
				elseif($recibo->estatus==3)
					Fpdf::Cell(20,8,'Credito',1,0,'C');
				elseif($recibo->estatus==6)
					Fpdf::Cell(20,8,'Cancelado',1,0,'C');
				Fpdf::Cell(20,8,'$'.number_format($recibo->cantidad,2),1,1,'L');
			}else
			{
				Fpdf::Cell(10,8,$key+1,1,0,'C',true);
				Fpdf::Cell(50,8,$recibo->paciente->nombre,1	,0,'L',true);
				Fpdf::Cell(20,8,$recibo->fecha,1,0,'C',true);
				Fpdf::Cell(20,8,$recibo->id,1,0,'C',true);
				Fpdf::Cell(20,8,$recibo->folio,1,0,'C',true);
				Fpdf::Cell(30,8,utf8_decode($recibo->tipo_pago),1,0,'L',true); 
				if($recibo->estatus==1)
					Fpdf::Cell(20,8,'Emitido',1	,0,'C',true); 
				elseif($recibo->estatus==2)
					Fpdf::Cell(20,8,'Pagado',1	,0,'C',true); 
				elseif($recibo->estatus==3)
					Fpdf::Cell(20,8,'Credito',1,0,'C',true);
				elseif($recibo->estatus==6)
					Fpdf::Cell(20,8,'Cancelado',1,0,'C');
				Fpdf::Cell(20,8,'$'.number_format($recibo->cantidad,2),1,1,'L',true);
			}
		}
		Fpdf::SetFillColor(200,220,255);
		Fpdf::Cell(140);
		Fpdf::Cell(20,8,'Total: ',1,0,'L',true); 
		Fpdf::Cell(30,8,'$'.number_format($totalReporte,2),1,0,'L'); 
		Fpdf::SetTitle('Reporte_recibos'.' _'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Recibo _'.date('Y-m-d').'.pdf'), 200,$headers);
	}

///////////////////////////////////////////////////////////////////////
	// public function ventasTotalesCortePdf() Funcion Alternativa
	// {
	// 		$header = ['#', 'Nombre','Cantidad','Precio U.', 'Precio T.'];
	// 		Fpdf::AddPage();

	// 	//////////////////times  14 normal inicio
	// 		//Tipo de documento
	// 		Fpdf::ln(-20);
	// 		Fpdf::SetFont('times','I',16);
	// 		Fpdf::Cell(60);
	// 		Fpdf::Cell(60,20,'Ventas',0	,0,'C'); 
	// 		Fpdf::Ln();
			

	// 	//////////////////times  14 normal fin	
	// 	$usuarios=User::where('tipo',3)->get();
	// 	$productos=Producto::where('categoria','Suplemento')->get();
		

	// 	foreach ($usuarios as $usuario) {
			
	// 		Fpdf::SetFont('times','B',12);
	// 		Fpdf::SetFillColor(250,220,255);
	// 		Fpdf::Cell(180,6,utf8_decode($usuario->name).' (Ventas en Efectivo)',1,0,'C',true);
	// 		Fpdf::Ln();
	// 		$ventasEfectivo=0;
	// 		$ventasCredito=0;
	// 		$eritro120=0;
	// 		$eritro200=0;
	// 		$eritro1000=0;
	// 		$ventro75=0;
	// 		$ventro55=0;


	// 		foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',1)->get() as $venta) {
	// 		////////////////// tabla inicio
	// 			//// Tabla Cabecera Inicio
	// 			Fpdf::SetFont('times','B',12);
	// 			Fpdf::SetFillColor(200,220,255);
	// 			Fpdf::Cell(180,6,utf8_decode($venta->cliente),1,0,'C',true);
	// 			Fpdf::Ln();
	// 				Fpdf::Cell(20,6,$header[0],1,0,'C',true);
	// 				Fpdf::Cell(80,6,$header[1],1,0,'C',true);
	// 				Fpdf::Cell(30,6,$header[2],1,0,'C',true);
	// 				Fpdf::Cell(25,6,$header[3],1,0,'C',true);
	// 				Fpdf::Cell(25,6,$header[4],1,0,'C',true);
				
	// 			Fpdf::Ln();
	// 			//// Tabla Cabecera Fin
	// 			//// Tabla Cuerpo Inicio
				
	// 			//// Tabla Cuerpo Fin
	// 			Fpdf::SetFont('arial','I',10);
	// 			foreach ($venta->productos as $key => $producto) {
	// 				Fpdf::Cell(20,6,$key+1,1,0,'C');
	// 				Fpdf::Cell(80,6,utf8_decode($producto->nombre),1,0,'L');
	// 				if($producto->pivot->cantidad==1)
	// 					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion,1,0,'L');
	// 				else
	// 					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion.'s',1,0,'L');
	// 				Fpdf::Cell(25,6,'$'.$producto->pivot->precio.'.00',1,0,'L');
	// 				Fpdf::Cell(25,6,'$'.($producto->pivot->precio*$producto->pivot->cantidad).'.00',1,0,'L');
	// 				Fpdf::Ln();
	// 				//Fpdf::Cell(25,6,$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad.'.00',1,0,'L'); //prueba
	// 				$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
	// 				if($producto->id==70 && $producto->pivot->precio==166.66){
	// 					$eritro1000++;
	// 				}
	// 				if($producto->id==70 && $producto->pivot->precio==120){
	// 					$eritro120+=$producto->pivot->cantidad;
	// 				}
	// 				if($producto->id==70 && $producto->pivot->precio==200){
	// 					$eritro200+=$producto->pivot->cantidad;
	// 				}
	// 				if($producto->id==102 && $producto->pivot->precio==55){
	// 					$ventro55+=$producto->pivot->cantidad;
	// 				}
	// 				if($producto->id==102 && $producto->pivot->precio==75){
	// 					$ventro75+=$producto->pivot->cantidad;
	// 				}

					
	// 			}
				
	// 		////////////////// tabla Cuerpo fin
	// 		////// Tabla Footer Inicio
	// 				Fpdf::Cell(130);
	// 				Fpdf::Cell(25,6,'Total: ',1,0,'R',true);
	// 				Fpdf::Cell(25,6,'$'.$venta->importe.'.00',1,0,'L',true);
	// 				Fpdf::Ln();
	// 				$ventasEfectivo+=$venta->importe;
	// 		////   Tabla Footer Fin
	// 		}
	// 		Fpdf::SetFont('times','B',12);
	// 		Fpdf::SetFillColor(250,220,255);
	// 		Fpdf::Cell(180,6,utf8_decode($usuario->name).' (Ventas a Credito) ',1,0,'C',true);
	// 		Fpdf::Ln();
	// 		foreach (Venta::where('corte',0)->where('user_id',$usuario->id)->where('estatus',2)->get() as $venta) {
	// 		////////////////// tabla inicio
	// 			//// Tabla Cabecera Inicio
	// 			Fpdf::SetFont('times','B',12);
	// 			Fpdf::SetFillColor(200,220,255);
	// 			Fpdf::Cell(180,6,utf8_decode($venta->cliente),1,0,'C',true);
	// 			Fpdf::Ln();
	// 				Fpdf::Cell(20,6,$header[0],1,0,'C',true);
	// 				Fpdf::Cell(80,6,$header[1],1,0,'C',true);
	// 				Fpdf::Cell(30,6,$header[2],1,0,'C',true);
	// 				Fpdf::Cell(25,6,$header[3],1,0,'C',true);
	// 				Fpdf::Cell(25,6,$header[4],1,0,'C',true);
				
	// 			Fpdf::Ln();
	// 			//// Tabla Cabecera Fin
	// 			//// Tabla Cuerpo Inicio
				
	// 			//// Tabla Cuerpo Fin
	// 			Fpdf::SetFont('arial','I',10);
	// 			foreach ($venta->productos as $key => $producto) {
	// 				Fpdf::Cell(20,6,$key+1,1,0,'C');
	// 				Fpdf::Cell(80,6,utf8_decode($producto->nombre),1,0,'L');
	// 				if($producto->pivot->cantidad==1)
	// 					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion,1,0,'L');
	// 				else
	// 					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->presentacion.'s',1,0,'L');
	// 				Fpdf::Cell(25,6,'$'.$producto->pivot->precio.'.00',1,0,'L');
	// 				Fpdf::Cell(25,6,'$'.($producto->pivot->precio*$producto->pivot->cantidad).'.00',1,0,'L');
	// 				Fpdf::Ln();
	// 				//Fpdf::Cell(25,6,$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad.'.00',1,0,'L'); //prueba
	// 				$productos->find($producto->id)->TotalProducto+=$producto->pivot->cantidad;
					
	// 			}
				
	// 		////////////////// tabla Cuerpo fin
	// 		////// Tabla Footer Inicio
	// 				Fpdf::Cell(130);
	// 				Fpdf::Cell(25,6,'Total: ',1,0,'R',true);
	// 				Fpdf::Cell(25,6,'$'.$venta->importe.'.00',1,0,'L',true);
	// 				Fpdf::Ln();
	// 				$ventasCredito+=$venta->importe;
	// 		////   Tabla Footer Fin
	// 		}
	// 			Fpdf::Ln();
	// 				Fpdf::Cell(50,6,'Producto',1,0,'C',true);
	// 				Fpdf::Cell(30,6,'Cantidad',1,0,'C',true);
	// 				Fpdf::Cell(50,6,' Total Ventas en Efectivo',1,0,'C',true);
	// 				Fpdf::Cell(50,6,' Total Ventas a credito',1,0,'C',true);
	// 				Fpdf::Ln();
	// 				Fpdf::Cell(80);
	// 				Fpdf::SetFont('arial','B',10);
	// 				Fpdf::Cell(50,5,'$'.$ventasEfectivo,1,0,'C');
	// 				Fpdf::Cell(50,5,'$'.$ventasCredito,1,0,'C');
	// 				Fpdf::SetFont('arial','I',8);
	// 				Fpdf::Ln();
	// 				Fpdf::Cell(80);
	// 				Fpdf::Cell(50,5,'Eritropoyetina 200',1,0,'C');
	// 				Fpdf::Cell(50,5,$eritro200,1,0,'C');
	// 				Fpdf::Ln();
	// 				Fpdf::Cell(80);
	// 				Fpdf::Cell(50,5,'Eritropoyetina 120',1,0,'C');
	// 				Fpdf::Cell(50,5,$eritro120,1,0,'C');
	// 				Fpdf::Ln();
	// 				Fpdf::Cell(80);
	// 				Fpdf::Cell(50,5,'Eritropoyetina 1000',1,0,'C');
	// 				Fpdf::Cell(50,5,$eritro1000,1,0,'C');
	// 				Fpdf::Ln();
	// 				Fpdf::Cell(80);
	// 				Fpdf::Cell(50,5,'Ventro 75',1,0,'C');
	// 				Fpdf::Cell(50,5,$ventro75,1,0,'C');
	// 				Fpdf::Ln();
	// 				Fpdf::Cell(80);
	// 				Fpdf::Cell(50,5,'Ventro 55',1,0,'C');
	// 				Fpdf::Cell(50,5,$ventro55,1,0,'C');
	// 				Fpdf::Ln(-30);
	// 			Fpdf::SetFont('arial','I',8);
	// 			Fpdf::Ln();	
	// 			foreach ($productos as $producto) {
	// 				Fpdf::Cell(50,5,$producto->nombre,1,0,'C');
	// 				if($producto->TotalProducto==1)
	// 				Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion,1,0,'C');
	// 				else{
	// 					if($producto->TotalProducto==0)
	// 						$producto->TotalProducto=0;
	// 					Fpdf::Cell(30,5,$producto->TotalProducto.' '.$producto->presentacion.'s',1,0,'C');
	// 				}
					
	// 				Fpdf::Ln();
	// 			}


	// 	}

		
		
		
	// 		Fpdf::SetTitle('Ventas totales del corte '.date('Y-m-d'));
	// 	$headers=['Content-Type'=>'application/pdf'];
	// 	return Response::make(Fpdf::Output('I','Ventas totales del corte '.date('Y-m-d').'.pdf'), 200,$headers);
        
		
	// }
}



		