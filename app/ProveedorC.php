<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProveedorC extends Model
{
    protected $table = 'proveedoresC';
    protected $fillable = ['id', 'nit', 'nombre', 'telefono', 'fax', 'celular', 'direccion', 'servicio', 'sistema'];
}
