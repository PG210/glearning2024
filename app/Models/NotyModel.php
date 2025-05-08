<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotyModel extends Model
{
    protected $table = 'mensaje';

    protected $fillable = [
        'tipo',
        'tiempo',
        'dia',
        'hora',
        'contenido',
        'ultimoenvio'
    ];
}
