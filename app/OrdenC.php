<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenC extends Model
{
    protected $table = 'ordenesC';
    protected $fillable = ['provedor', 'nombre', 'codigo','descr_tipo','nombre_proveedor','sistema_p'];
}
