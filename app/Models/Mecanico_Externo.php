<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mecanico_Externo extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'mecanico_extreno';
    protected $fillable = [
        'Nombre', 'Apellido_P', 'Apellido_M', 'Telefono', 'Ciudad', 'Nombre_Taller', 'activo'
    ];
}
