<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'precio', 'categoria',
    ];
    //
    public function unidades()
    {
        return $this->belongsToMany('App\Unidad', 'producto_unidads')->withPivot('cantidad');
    }

    public function pedidos()
    {
        return $this->belongsToMany('App\Pedido', 'pedido_productos');
    }

    public function ventas()
    {
        return $this->belongsToMany('App\Venta', 'producto_ventas');
    }

    public function registros()
    {
        return $this->belongsToMany('App\Registro', 'producto_registros');
    }

    public function proveedores()
    {
        return $this->belongsToMany('App\Proveedor', 'producto_proveedors')->withPivot('precio');
    }

   

}

