<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Herramientas extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'herramientas';
    protected $fillable = [
        'Herramienta','Cantidad', 'Cant_his', 'tipo', 'activo','foto', 

    ];
}
