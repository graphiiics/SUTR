<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signo extends Model
{
	protected $table = 'signos';
    protected $primaryKey = 'id';
    //
    public function sesion()
    {
        return $this->belongsTo('App\Sesion');
    }
}
