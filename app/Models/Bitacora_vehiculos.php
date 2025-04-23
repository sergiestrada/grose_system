<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bitacora_vehiculos extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'bitacora_vehiculos';
    protected $fillable = [
        'Nombre_Vehiculo', 
        'Placa', 
        'Kilometraje', 
        'Responsable', 
        'Tipo_Servicio', 
        'Mecanico', 
        'Tipo_mecanico', 
        'Proveedor',
        'Fecha_servicio', 
        'Prox_Fecha_Serv', 
        'Comentarios', 
        'num_int', 
        'revision', 
        'medida'
    ];
}

