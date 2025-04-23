<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculos_pesados extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'vehiculos_pesados';
    protected $fillable = [
        'Marca', 
        'Modelo', 
        'No_Serie', 
        'Ano', 
        'Poliza', 
        'Tipo', 
        'Comentarios', 
        'Ruta', 
        'numint'

    ];
}

