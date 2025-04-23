<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsivas_medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'responsivas_medicion';
    protected $fillable = [
        'responsiva', 'obra', 'encargado', 'cargo_e', 'responsable', 'cargo', 'fecha_r', 'fecha_e', 'status', 'com'
    ];
}

