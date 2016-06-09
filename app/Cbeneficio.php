<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cbeneficio extends Model
{
    protected $table = 'cbeneficios';
    protected $primaryKey = 'id';


    public function beneficio()
    {
        return $this->belongsTo('App\Beneficio');
    }
}
