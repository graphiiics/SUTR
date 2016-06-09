<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
     protected $table = 'unidads';
     protected $primaryKey = 'id';

    public function recibos()
    {
        return $this->hasMany('App\Recibo');
    }

    public function pacientes()
    {
        return $this->hasMany('App\Paciente');
    }

    public function beneficios()
    {
        return $this->hasMany('App\Beneficio');
    }

    public function pedidos()
    {
        return $this->hasMany('App\Pedido');
    }

    public function registros()
    {
        return $this->hasMany('App\Registro');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'producto_unidads');
    }
}
