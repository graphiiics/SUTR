<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
     protected $table = 'empresas';
     protected $primaryKey = 'id';
     protected $fillable = [
        'razon_social','rfc','telefono','direccion','correo','persona_contacto'
    ];
     public function beneficios()
    {
        return $this->hasMany('App\Beneficio');
    }
}
