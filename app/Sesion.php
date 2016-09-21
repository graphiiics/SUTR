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
    public function recibo(){
    	return $this->belongsTo('App\Recibo');
    }

    
}
