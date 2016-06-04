<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
     protected $table = 'recibos';
     protected $primaryKey = 'id';

     public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

    public function crecibos()
    {
        return $this->hasMany('App\Crecibo');
    }

    public function concepto()
    {
        return $this->belongsTo('App\Concepto');
    }

    public function beneficio()
    {
        return $this->belongsTo('App\Beneficio');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }


}
