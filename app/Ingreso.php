<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'concepto','fecha','importe','corte','fecha_corte','observaciones'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
