<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicionReparacion extends Model
{
    use HasFactory;
   
    // Especificamos el nombre de la tabla
    protected $table = 'medicion_reparacion';

    // Especificamos los campos que pueden ser asignados masivamente
    protected $fillable = [
        'resposiva',
        'origen',
        'estatus',
        'tipo',
      
    ];

    // Si la tabla tiene una columna de timestamp llamada 'ceated_at', indicamos que se debe usar
    const CREATED_AT = 'ceated_at'; // Esto se hace para evitar confusión con 'created_at' de Laravel
    const UPDATED_AT = 'updated_at';


}
