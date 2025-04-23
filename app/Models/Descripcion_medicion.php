<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descripcion_medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'desc_form_med';
    protected $fillable = ['Descripcion', 'ID_Resp', 'Cantidad', 'tipo'];
}

