<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculos extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'vehiculos';
    protected $fillable = [
        'Nombre_Id', 
        'Marca', 
        'Modelo', 
        'No_Serie', 
        'Ano', 
        'Color', 
        'Kilometraje', 
        'Placa', 
        'Poliza', 
        'Tipo', 
        'Comentarios', 
        'Ruta', 
        'tc', 
        'afianzadora',
        'vigencia_fianza', 
        'no_gps','estatus_gsp', 
        'no_motor',
        'numint'
    ];
}

