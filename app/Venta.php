<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'producto_ventas')->withPivot('cantidad');
    }
}
