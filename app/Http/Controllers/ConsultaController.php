<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Fpdf;
use Response;

class ConsultaController extends Controller
{
   public function index()
   {
   		return view('consulta/index');
   }
   public function imprimirHoja(Request $request)
   {
   		//return $request->all();
			Fpdf::AddPage();
			
	
		//////////////////times  14 normal inicio
			//Tipo de documento
			Fpdf::ln(-20);
			Fpdf::SetFont('times','I',16);
			Fpdf::Cell(60);
			Fpdf::Cell(60,20,'Hoja de '.utf8_decode('Análisis Clinicos'),0	,0,'C'); 
			Fpdf::Image('../public/img/laboratorioUTR.png',30,55,150,0,'PNG');
		
		//////////////////times  14 normal fin
			Fpdf::SetFont('times','',14);	
			Fpdf::ln(15);
			Fpdf::Cell(10);
			Fpdf::Cell(100,10,'Nombre: '.utf8_decode($request->input('nombre')),0	,0,'L');
			Fpdf::Cell(40,10,'Sexo: '.$request->input('sexo'),0	,0,'L');
			Fpdf::Cell(40,10,'Fecha: '.date('Y-m-d'),0	,0,'L');
			if($request->input('edad')!=''){
			Fpdf::ln(5);
			Fpdf::Cell(10,10,'',0	,0,'L');
			Fpdf::Cell(40,10,'Edad: '.$request->input('edad').utf8_decode('Años') ,0	,0,'L');
			Fpdf::ln(-5);
			}
			/////////// Signos vitales
			if($request->input('sg')=='on'){	
			Fpdf::ln(10);
			Fpdf::SetFont('times','B',14);	
			Fpdf::Cell(180,20,'Signos vitales',0	,0,'C'); 
			Fpdf::ln(6);
			Fpdf::SetFont('Courier','',12);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' T/A :'.$request->input('ta'),0	,0,'L'); 
			Fpdf::Cell(50,20,' F.C. :'.$request->input('fc'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' F.R :'.$request->input('fr'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Temp :'.$request->input('temp'),0	,0,'L'); 
			Fpdf::Cell(15);
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(150,20,' Hemoglobina :'.$request->input('hemoglobina'),0	,0,'L'); 
			/////////// Termina Signos Vitales
			Fpdf::Line(20,(Fpdf::getY()+15),190,(Fpdf::getY()+15));
		}
		if($request->input('quimica')=='on'){	
			///////////  Quimica 13			
			Fpdf::ln(15);
			Fpdf::SetFont('times','B',14);	
			Fpdf::Cell(180,20,utf8_decode('Química General 13'),0	,0,'C'); 
			Fpdf::ln(6);
			Fpdf::SetFont('Courier','',12);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Albumina :'.$request->input('alb-13'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Fosfatasa alcalina :'.$request->input('alf-13'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Alanina Transaminasa :'.$request->input('alt-13'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Amilasa :'.$request->input('amy-13'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Aspartato Aminotransferasa :'.$request->input('ast-13'),0	,0,'L'); 
			Fpdf::Cell(50,20,utf8_decode(' Nitrógeno Ureico :').$request->input('bun-13'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Calcio :'.$request->input('ca-13'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Creatinina:'.$request->input('cre-13'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Gamma Glutamil Transpeptidasa  :'.$request->input('ggt-13'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Glucosa :'.$request->input('glu-13'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' T. Bilirrubina :'.$request->input('tbil-13'),0	,0,'L'); 
			Fpdf::Cell(50,20,' T. Protenias :'.$request->input('tp-13'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Acido Urico :'.$request->input('ua-13'),0	,0,'L'); 
			///////////Temina Quimica 13
			Fpdf::Line(20,(Fpdf::getY()+15),190,(Fpdf::getY()+15));
		}
		if($request->input('orina')=='on'){	
			///////////  Examen General de Orina		
			Fpdf::ln(15);
			Fpdf::SetFont('times','B',14);	
			Fpdf::Cell(180,20,utf8_decode('Examén General de Orina'),0	,0,'C'); 
			Fpdf::ln(6);
			Fpdf::SetFont('Courier','',12);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Leucos :'.$request->input('leu-orina'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Nitratos :'.$request->input('nit-orina'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Proteinas :'.$request->input('pro-orina'),0	,0,'L'); 
			Fpdf::Cell(50,20,' pH :'.$request->input('ph-orina'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' BLO :'.$request->input('blo-orina'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Densidad :'.$request->input('sg-orina'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Ketonar :'.$request->input('ket-orina'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Bilirrubina :'.$request->input('bil-orina'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Glucosa :'.$request->input('glu-orina'),0	,0,'L'); 
			
			///////////Temina Examen General de Orina
			Fpdf::Line(20,(Fpdf::getY()+15),190,(Fpdf::getY()+15));
		}
		if($request->input('renal')=='on'){	
			///////////  Panel Renal		
			Fpdf::ln(15);
			Fpdf::SetFont('times','B',14);	
			Fpdf::Cell(180,20,utf8_decode('Panel Renal'),0	,0,'C'); 
			Fpdf::ln(6);
			Fpdf::SetFont('Courier','',12);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Albumina :'.$request->input('alb-renal'),0	,0,'L'); 
			Fpdf::Cell(50,20,utf8_decode(' Nitrógeno Ureico :').$request->input('bun-renal'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Calcio :'.$request->input('ca-renal'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Cloro :'.$request->input('cl-renal'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Creatinina :'.$request->input('cre-renal'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Glucosa :'.$request->input('glu-renal'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Potasio :'.$request->input('k-renal'),0	,0,'L'); 
			Fpdf::Cell(50,20,' Sodio :'.$request->input('na-renal'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' T. Dioxido de Carbono :'.$request->input('tco-renal'),0,0,'L'); 
			Fpdf::Cell(50,20,' Fosforo :'.$request->input('fos-renal'),0	,0,'L');  
			Fpdf::Line(20,(Fpdf::getY()+15),190,(Fpdf::getY()+15));
			///////////Temina Panel Renal
		}
		if($request->input('serologia')=='on'){	
			///////////  Panel Renal		
			Fpdf::ln(15);
			Fpdf::SetFont('times','B',14);	
			Fpdf::Cell(180,20,utf8_decode('Serología'),0,0,'C'); 
			Fpdf::ln(6);
			Fpdf::SetFont('Courier','',12);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Anti-VIH :                     '.$request->input('vih'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Anti-HBsAg :                   '.$request->input('hbsag'),0	,0,'L'); 
			Fpdf::ln(6);
			Fpdf::Cell(15);
			Fpdf::Cell(100,20,' Anti-HCV :                     '.$request->input('hcv'),0	,0,'L'); 
			Fpdf::Line(20,(Fpdf::getY()+15),190,(Fpdf::getY()+15));
			
			///////////Temina Panel Renal
		}
			//Fpdf::Line(20,(Fpdf::getY()+15),190,(Fpdf::getY()+15));
			Fpdf::SetY(246); 
			
			Fpdf::SetFont('arial','',6);
			Fpdf::Cell(180,20,'Unidad de Terapia Renal S.C',0	,0,'R'); 
			Fpdf::ln(2);
			Fpdf::Cell(180,20,'Dr. Javier Ortiz Gonzalez',0	,0,'R'); 
			Fpdf::ln(2);
			Fpdf::Cell(180,20,'Cel.492 893 0347',0	,0,'R'); 
			Fpdf::ln(2);
			Fpdf::Cell(180,20,'nefror@hotmail.com',0	,0,'R'); 
			Fpdf::ln(2);
			Fpdf::Cell(180,20,'www.utrzac.com.mx',0	,0,'R'); 
			
			
		
			Fpdf::SetTitle('Analisis_'.$request->input('nombre').'_'.date('Y-m-d'));
		$headers=['Content-Type'=>'application/pdf'];
		return Response::make(Fpdf::Output('I','Analisis_'.$request->input('nombre').'_'.date('Y-m-d').'.pdf'), 200,$headers);
   }

}
