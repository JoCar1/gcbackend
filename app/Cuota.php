<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $fillable = ['numero_cuota', 'fecha_pago', 'monto', 'id_plan_pago','codigo_oc'];
}
