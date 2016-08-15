<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    protected $fillable = [
        'nombre', 'gerente', 'telefono','correo',
    ];
    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'producto_proveedors')->withPivot('precio','updated_at');
    }
    public function compras()
    {
        return $this->hasMany('App\Compra');
    }
}
