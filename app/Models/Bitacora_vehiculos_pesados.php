<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bitacora_vehiculos_pesados extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'bitacora_vehiculo_pesado';
    protected $fillable = [
        'Nombre_Vehiculo',
        'Responsable', 
        'Tipo_Servicio',
        'Mecanico', 
        'Tipo_mecanico', 
        'Proveedor', 
        'Fecha_servicio', 
        'Prox_fecha_serv', 
        'Comentarios', 
        'horometro', 
        'Ruta', 
        'num_int' 
    ];
}

