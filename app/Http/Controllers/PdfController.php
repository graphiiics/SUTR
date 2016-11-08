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
class PdfController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
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

public function ventasTotalesCortePdf()
{

	$usuarios=User::where('tipo',3)->get();
	$productos=Producto::where('categoria','Suplemento')->get();	
	foreach ($usuarios as $usuario) {
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

	}

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



		