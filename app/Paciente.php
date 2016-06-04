<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
     protected $table = 'pacientes';
     protected $primaryKey = 'id';

   public function sesiones()
    {
        return $this->hasMany('App\Sesion');
    }

    public function recibos()
    {
        return $this->hasMany('App\Recibo');
    }

    public function beneficios()
    {
        return $this->hasMany('App\Beneficio');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

}
