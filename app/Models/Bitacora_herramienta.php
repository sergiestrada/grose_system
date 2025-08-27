<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bitacora_herramienta extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'bitacora_herramienta';
    protected $fillable = [  
        'id_her', 
        'id_retorno',
        'cod_barras', 
        'codigo', 
        'fecha', 
        'hora', 
        'cantidad',
        'comentario', 
        'rep_fecha', 
        'id_retorno', 
        'responsable', 
        'stat'
     ];
}
