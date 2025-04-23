<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mecanico_Interno extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'mecanico_interno';
    protected $fillable = [
        'Nombre', 'Apellido_P', 'Apellido_M', 'Telefono', 'Obra', 'activo'
    ];
}
