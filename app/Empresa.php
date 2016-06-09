<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
     protected $table = 'empresas';
     protected $primaryKey = 'id';

     public function beneficios()
    {
        return $this->hasMany('App\Beneficio');
    }
}
