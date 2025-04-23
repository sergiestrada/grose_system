<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentarios extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'comentarios';
    protected $fillable = ['herr', 'codigo', 'comentario', 'fecha','origen', 'status'];
}

