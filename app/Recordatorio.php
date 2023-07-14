<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    protected $fillable = ['asunto', 'fecha', 'recordatorio', 'codigo_oc'];
}
