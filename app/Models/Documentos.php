<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Documentos extends Model
{
    // Incluir el trait SoftDeletes en tu modelo

    protected $table = 'documentos';
    protected $fillable = [
        'Id_doc', 
        'T_doc', 
        'Iden', 
        'Doc'
    ];
}

