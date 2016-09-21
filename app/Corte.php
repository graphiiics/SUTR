<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
	protected $fillable = [
        'importe','fecha_inicio'
    ];
     public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ventas()
    {
        return $this->belongsToMany('App\Venta', 'corte_ventas');
    }
   
}
