<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria_medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'categoria_medicion';
    protected $fillable = ['Categoria', 'estatus'];
}

