<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutricionData extends Model
{
    protected $fillable = [
        'paciente_id',
		'grasa',
		'mm',
		'agua',
		'gv',
		'peso_seco',
		'glucosa',
		'urea',
		'creatinina',
		'acido_urico',
		'bun',
		'hb',
		'hto',
		'leucocitos',
		'albumina',
		'pts_totales',
		'colesterol',
		'trigleceridos',
		'potasio',
		'sodio',
		'fosforo',
		'calcio',
		'magnesio',
		'nifedipino',
		'acido_folico',
		'furosemida',
		'tribedoce',
		'omeprazol',
		'valoracion',
		'indicaciones',

		'imc',
		'estatura',
		'cmb',
		'c_m',
		'pct',
		'complexion',
        'ambd',
        'vcm',
        'wbc',
        'rbc',
        'plq',
        'globulinas',
        'hdl',
        'ldl',
        'vldl',
        'cloro',
        'exploracion_fisica',
        'valoracion_medica',
        'indicaciones_medicas',
        'nota_medica',
        'valoracion_nutricional_seguimiento',
        'cambio_de_peso',
        'ingesta_dietetica',
        'sintomas_gastrointestinales',
        'capacidad_funcional',
        'comorbilidades',
        'examen_fisico',
        'signos_perdida_muscular'
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

}
