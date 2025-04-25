<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'menus'; // Nombre de tabla explícito
    
    protected $fillable = [
        'nombre',
        'imagenes',
        // Agrega otros campos necesarios
    ];
}