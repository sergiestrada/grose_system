<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrestamosMaquinaria extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'prestamo_maquinaria';
    protected $fillable = [
         'herr', 'cantidad', 'responsable','stat', 'codigo','com', 'status'
    ];
}

