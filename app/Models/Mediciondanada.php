<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mediciondanada extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'medicion_danada';
    protected $fillable = [
        'herramineta', 'comentario', 'id_resp', 'status' 

    ];
}
