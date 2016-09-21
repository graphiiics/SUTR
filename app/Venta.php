<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'estatus','fecha_liquidacion','fecha_corte','corte',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'producto_ventas')->withPivot('cantidad','precio');
    }
    public function cortes()
    {
        return $this->belongsToMany('App\Corte', 'corte_ventas');
    }


}
