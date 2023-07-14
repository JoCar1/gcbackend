<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Responsable extends Model
{
    protected $fillable = [
        'codigo_oc',
        'responsabilidad',
        'user_id' // agregar este atributo
    ];
}
