<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
	protected $fillable = [
        'estado'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
