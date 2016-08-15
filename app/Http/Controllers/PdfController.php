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
			Fpdf::Cell(60,10,'Realizado por: '.$pedido->user->name,0	,0,'C');
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
				Fpdf::Cell(60,6,$header[1],1,0,'C',true);
				Fpdf::Cell(45,6,$header[2],1,0,'C',true);
				Fpdf::Cell(45,6,$header[3],1,0,'C',true);
			
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',10);
			foreach ($pedido->productos as $key => $producto) {
				
				Fpdf::Cell(30,6,$key+1,1,0,'C');
				Fpdf::Cell(60,6,$producto->nombre,1,0,'L');
				Fpdf::Cell(45,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(45,6,$producto->pivot->cantidad.' '.$producto->tipo,1,0,'L');
				else
					Fpdf::Cell(45,6,$producto->pivot->cantidad.' '.$producto->tipo.'s',1,0,'L');
				Fpdf::Ln();

			}
			Fpdf::Ln();			
		////////////////// tabla fin

		///////////Comentario Inicio
			Fpdf::Cell(180,20,'Comentarios: '.$pedido->comentarios,0,0,'L');
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
						Fpdf::Cell(60,20,'Credito (Liquidado) el '.$venta->updated_at,0	,0,'C');
					}else{
						Fpdf::Cell(60,20,'Credito (Pendiente)',0	,0,'C');
					}
				}
			Fpdf::ln(15);
			Fpdf::Cell(60,10,'Realizada por: '.$venta->user->name,0	,0,'C');
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
				Fpdf::Cell(50,6,$producto->nombre,1,0,'L');
				Fpdf::Cell(30,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->tipo,1,0,'L');
				else
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->tipo.'s',1,0,'L');
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
			Fpdf::Cell(180,20,'Comentarios: '.$venta->comentarios,0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Venta'.$venta->id.'_'.$venta->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Venta'.$venta->id.'_'.$venta->fecha.'.pdf'), 200,$headers);
        
		
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
			Fpdf::Cell(60,10,'Realizado por: '.$registro->user->name,0	,0,'C');
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
				Fpdf::Cell(60,6,$header[1],1,0,'C',true);
				Fpdf::Cell(45,6,$header[2],1,0,'C',true);
				Fpdf::Cell(45,6,$header[3],1,0,'C',true);
			
			Fpdf::Ln();
			//// Tabla Cabecera Fin
			//// Tabla Cuerpo Inicio
			
			//// Tabla Cuerpo Fin
			Fpdf::SetFont('arial','I',10);
			foreach ($registro->productos as $key => $producto) {
				
				Fpdf::Cell(30,6,$key+1,1,0,'C');
				Fpdf::Cell(60,6,$producto->nombre,1,0,'L');
				Fpdf::Cell(45,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(45,6,$producto->pivot->cantidad.' '.$producto->tipo,1,0,'L');
				else
					Fpdf::Cell(45,6,$producto->pivot->cantidad.' '.$producto->tipo.'s',1,0,'L');
				Fpdf::Ln();

			}
			Fpdf::Ln();			
		////////////////// tabla fin

		///////////Comentario Inicio
			Fpdf::Cell(180,20,'Comentarios: '.$registro->comentarios,0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Registro'.$registro->id.'_'.$registro->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Registro'.$registro->id.'_'.$registro->fecha.'.pdf'), 200,$headers); 
		
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
			Fpdf::Cell(60,10,'Realizada por: '.$compra->user->name,0	,0,'C');
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
				Fpdf::Cell(50,6,$producto->nombre,1,0,'L');
				Fpdf::Cell(30,6,$producto->categoria,1,0,'L');
				if($producto->pivot->cantidad==1)
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->tipo,1,0,'L');
				else
					Fpdf::Cell(30,6,$producto->pivot->cantidad.' '.$producto->tipo.'s',1,0,'L');
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
			Fpdf::Cell(180,20,'Comentarios: '.$compra->comentarios,0,0,'L');
		///////////Comentario Fin
			Fpdf::SetTitle('Compra'.$compra->id.'_'.$compra->fecha);
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Compra'.$compra->id.'_'.$compra->fecha.'.pdf'), 200,$headers);
        
		
	}
	public function productosPdf(Compra $compra)
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
			foreach (Producto::all() as $key => $producto) {
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

	
}



		