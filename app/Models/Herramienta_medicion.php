<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Herramienta_medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'herramienta_medicion';
    protected $fillable = ['herramenta', 'codigo', 'cod_barras', 'marca', 'status'];
}

