<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
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
        return $this->belongsToMany('App\Producto', 'producto_registros');
    }
}
