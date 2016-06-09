<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
     protected $table = 'beneficios';
     protected $primaryKey = 'id';

    public function recibos()
    {
        return $this->hasMany('App\Recibo');
    }

    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function cbeneficios()
    {
        return $this->hasMany('App\Cbeneficio');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

}
