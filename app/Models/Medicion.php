<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'medicion';
    protected $fillable = [
        'codigo', 
        'cantidad', 
        'instrumento', 
        'descripcion', 
        'status', 
        'codigob', 
        'modelo', 
        'clasificacion' 

    ];
}
