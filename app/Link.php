<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function contrato()
    {
        return $this->belongsTo('App\Contrato');
    }
}
