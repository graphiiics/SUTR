<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
     public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'producto_compras')->withPivot('cantidad','precio');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
   
}
