<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamos extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'prestamos';
    protected $fillable = [
         'herr', 'cantidad', 'portador', 'responsable', 'fecha', 'hora', 'stat', 'codigo', 'marca','modelo', 'numser', 'com', 'status','fotos'
    ];
}

