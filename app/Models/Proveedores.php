<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedores extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'proveedor';
    protected $fillable = [
        'Nombre_Proveedor',
         'Ciudad',
          'Telefono', 
          'Nombre_contacto', 
          'Tipo', 
          'activo',
    ];
}

