<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maquinaria extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'maquinaria';
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
        'numint'

    ];
}
