<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metrica extends Model
{
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'comentarios',
        'referencia'
    ];
}
