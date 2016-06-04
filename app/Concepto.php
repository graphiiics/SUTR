<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
     protected $table = 'conceptos';
     protected $primaryKey = 'id';

     public function recibos()
    {
        return $this->hasMany('App\Recibo');
    }
}
