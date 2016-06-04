<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
     protected $table = 'sesions';
     protected $primaryKey = 'id';

      public function signos()
    {
        return $this->hasMany('App\Signo');
    }

     public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }
}
