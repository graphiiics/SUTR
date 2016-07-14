<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'users';
     protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function recibos()
    {
        return $this->hasMany('App\Recibo');
    }

    public function beneficios()
    {
        return $this->hasMany('App\Beneficio');
    }

    public function registros()
    {
        return $this->hasMany('App\Registro');
    }
    
    public function pedidos()
    {
        return $this->hasMany('App\Pedido');
    }

    public function ventas()
    {
        return $this->hasMany('App\Venta');
    }

    public function compras()
    {
        return $this->hasMany('App\Compra');
    }
}
