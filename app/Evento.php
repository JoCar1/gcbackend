<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Evento extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function emails()
    {
        return $this->hasMany('App\Email');
    }

    public function contrato()
    {
        return $this->belongsTo('App\Contrato');
    }

    public function notificaciones()
    {
        return $this->hasMany('App\Notificacion');
    }

    public function getFechaEventoAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    public function getFechaRecordatorioAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
}
