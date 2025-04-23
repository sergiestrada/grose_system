<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TempCosto extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    protected $table = 'tmp_costo';
    protected $fillable = [
        'material', 'cantidad'
    ];
}

