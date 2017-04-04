<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutricionData extends Model
{
    protected $fillable = [
        'user_id',
		'grasa',
		'mm',
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
		'indicaciones'
    ];

    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

}
