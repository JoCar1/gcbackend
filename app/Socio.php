<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function contratos()
    {
        return $this->hasMany('App\Contrato');
    }
}
