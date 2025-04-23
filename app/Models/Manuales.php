<?php

        namespace App\Models;
        
        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Eloquent\SoftDeletes;
        
        class Manuales extends Model
        {
            // Incluir el trait SoftDeletes en tu modelo
            use SoftDeletes;
            protected $table = 'manuales';
            protected $fillable = [
                'manual', 'fecha', 'lig'
        
            ];
        }
        


