<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes'; // Nombre de tabla explícito
    
    protected $fillable = [
        'nombre',
       
        // Agrega otros campos necesarios
    ];
}