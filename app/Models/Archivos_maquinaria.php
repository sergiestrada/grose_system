<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archivos_maquinaria extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'archivo_maquinaria';
    protected $fillable = [  
        'archivo', 'id_reponsiva'
     ];
}