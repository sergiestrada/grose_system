<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsables extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'responsable';
    protected $fillable = [
        'id',
        'Nombre',
        'Apellido_P',
        'Apellido_M', 
        'Numero_contacto', 
        'No_Empleado', 
        'Cargo', 
        'Estado',
        'Antiguedad', 
        'Fecha_alta',
        'Ruta'
    ];
    
}

