<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Herramientas_mantenimiento extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'herramientas_mantenimiento';
    protected $fillable = [
        'id_herramientas', 'herramienta', 'codigo', 'cod_barras', 'marca', 'status' ];
}
