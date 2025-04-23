<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historialmantenimientosmedicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'historial_mantenimientos_medicion';
    protected $fillable = ['id_her', 'fecha', 'fecha_prox', 'comentario'];
}

