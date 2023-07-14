<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contrato extends Model
{
    use SoftDeletes;
    
    protected $table = 'CONTRATOS';
    // protected $primaryKey = 'codigo_oc';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    // public function archivos()
    // {
    //     return $this->hasMany('App\Archivo');
    // }

    // public function links()
    // {
    //     return $this->hasMany('App\Link');
    // }

    // public function eventos()
    // {
    //     return $this->hasMany('App\Evento');
    // }

    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }

    // public function organizativaunidad()
    // {
    //     return $this->belongsTo('App\OrganizativaUnidad','organizativa_unidad_id');
    // }

    // public function socio()
    // {
    //     return $this->belongsTo('App\Socio');
    // }

    // public function categoria()
    // {
    //     return $this->belongsTo('App\Categoria');
    // }

    // public function responsablecontrato()
    // {
    //     return $this->belongsTo('App\User','responsable_contrato_user_id');
    // }

    // public function getFechaInicioAttribute($value){
    //     return Carbon::parse($value)->format('Y-m-d');
    // }
    // public function getFechaPlazoCancelacionAttribute($value){
    //     if ($value===null) {
    //         return '';
    //     } else {
    //         return $value?Carbon::parse($value)->format('Y-m-d'):null;
    //     }
    // }
    // public function getFechaFinAttribute($value){
    //     if ($value===null) {
    //         return '';
    //     } else {
    //         return $value?Carbon::parse($value)->format('Y-m-d'):null;
    //     }
    // }
    // public function getFechaProlongacionAttribute($value){
    //     if ($value===null) {
    //         return '';
    //     } else {
    //         return $value?Carbon::parse($value)->format('Y-m-d'):null;
    //     }
    // }
}
