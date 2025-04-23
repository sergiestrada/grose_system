<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Estados extends Model
{
    // Incluir el trait SoftDeletes en tu modelo

    protected $table = 'estados';
    protected $fillable = ['estado'];
}

