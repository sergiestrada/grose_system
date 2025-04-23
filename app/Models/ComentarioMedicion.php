<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioMedicion extends Model
{
    use HasFactory;

      // Especificamos el nombre de la tabla (si es diferente del nombre pluralizado del modelo)
      protected $table = 'comentarios_medicion';

      // Especificamos los campos que pueden ser asignados masivamente
      protected $fillable = [
          'medicion', 
          'comentario',

      ];
  
      // Si la tabla tiene una columna de timestamp personalizada (como 'created_at'), se indica aquí
      const CREATED_AT = 'created_at';
      const UPDATED_AT = 'updated_at';
}
