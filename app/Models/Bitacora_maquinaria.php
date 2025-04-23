<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bitacora_maquinaria extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'bitacora_maquinaria';
    protected $fillable = [
        'id_her', 
        'cod_barras',
        'codigo', 
        'fecha', 
        'hora', 
        'comentario', 
        'rep_fecha',
        'id_retorno', 
        'responsable',
         'stat' 
    ];
}
