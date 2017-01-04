<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folio_recibos extends Model
{
    public function recibo(){
    	return $this->belongsTo('App\Recibo');
    }
}