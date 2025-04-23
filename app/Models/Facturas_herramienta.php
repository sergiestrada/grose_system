<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facturas_herramienta extends Model
{
    // Incluir el trait SoftDeletes en tu modelo

    protected $table = 'fact_her';
    protected $fillable = [
        'idher', 'codigo', 'fecha', 'nombre'

    ];
}
