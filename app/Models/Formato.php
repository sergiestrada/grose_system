<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formato extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'formato';
    protected $fillable = [
        'Nombre','nom_equi', 'clave', 'modelo', 'marca', 'serie', 

    ];
}
