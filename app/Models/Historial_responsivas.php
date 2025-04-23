<?php

namespace App\Models;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historial_responsivas extends Model
{
    // Incluir el trait SoftDeletes en tu modelo
    use SoftDeletes;
    protected $table = 'historial_responsivas';
    protected $fillable = [
        'reponsable', 
        'Portador', 
        'fecha',  
        'codigo', 
        'status',
        'estatus'
    ];
    public function responsables()
    {
        return $this->belongsTo(Responsables::class,  'responsable' ,'id'); // Ajusta si tienes otro modelo para "responsable"
    }

    public function portadores()
    {
        return $this->belongsTo(Responsables::class, 'Portador','id'); // Ajusta si tienes otro modelo para "portador"
    }
}

