<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
     protected $table = 'pacientes';
     protected $primaryKey = 'id';
    protected $fillable = [
        'unidad_id','nombre', 'direccion','celular','telefono','estatus'
    ];
  

    public function recibos()
    {
        return $this->hasMany('App\Recibo');
    }

    public function beneficios()
    {
        return $this->hasMany('App\Beneficio');
    }

    public function hojaNutrcion()
    {
        return $this->hasMany('App\NutricionData');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

}
