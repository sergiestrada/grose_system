<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagenes_medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'imagenes_medicion';
    protected $fillable = ['Dir', 'Resp', 'fecha'];
}

