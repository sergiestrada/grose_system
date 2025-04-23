<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamos_medicion extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'prestamos_medicion';
    protected $fillable = [
        'herr', 'cantidad', 'cantidad_e', 'responsable', 'fecha', 'hora', 'stat', 'com', 'id_resp', 'idresp'

    ];
}
