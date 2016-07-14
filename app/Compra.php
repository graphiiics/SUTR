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
        return $this->belongsToMany('App\Producto', 'pedido_productos')->withPivot('cantidad');
    }
}
