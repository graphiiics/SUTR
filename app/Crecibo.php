<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crecibo extends Model
{
     protected $table = 'crecibos';
     protected $primaryKey = 'id';


     public function recibo()
    {
        return $this->belongsTo('App\Recibo');
    }
}
