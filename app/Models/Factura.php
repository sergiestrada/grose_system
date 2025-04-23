<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'factura';
    protected $fillable = [
        'Vh_ligado', 'id_lig', 'Archivo', 'fecha','hora', 'iden', 'monto', 'tfactura' 

    ];
}
