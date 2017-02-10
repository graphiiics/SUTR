<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Recibo;

use Illuminate\Support\Collection;

class ExcelController extends Controller
{
    //
    public function reporteRecibosExcel(Request $request)
    {
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
		
		foreach ($recibos as $recibo) {
			$recibo->Folio=$recibo->folio;
			$recibo->Paciente=$recibo->paciente->nombre;
			$recibo->Unidad=$recibo->unidad->nombre;
			$recibo->Fecha=$recibo->fecha;
			$recibo->Concepto=$recibo->tipo_pago;
			$recibo->Cantidad=$recibo->cantidad;
		}
		
		 Excel::create('Reporte_'.$fechas.'_'.$unidad, function($excel) use($recibos){

            $excel->sheet('Recibos', function($sheet) use($recibos) {
                $sheet->fromArray($recibos);
                $sheet->mergeCells('A1:L1');
 
            });
        })->export('xls');

    }
}
