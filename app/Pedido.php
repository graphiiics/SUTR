<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'pedido_productos');
    }
}
