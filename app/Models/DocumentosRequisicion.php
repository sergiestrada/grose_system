<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentosRequisicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'documentos_requisicion';
    protected $fillable = [
        'id_requisicion', 'documento', 'monto'

    ];
}
