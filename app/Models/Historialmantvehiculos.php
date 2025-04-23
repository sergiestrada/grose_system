<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historialmantvehiculos extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'historial_mantenimiento_vehiculos';
    protected $fillable = [
        'id_mant',
        'tipo',
        'fecha',
        'fecha_ini',
        'fecha_fin',
        'servicio',
        'proveedor',
        'mecanico',
        'taller',
        't_mecanico',
        'comentario',
        'km_anterior',
        'km_actual'
    ];
}
