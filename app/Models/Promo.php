<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
      protected $fillable = [
            'nombre',
            'imagenes',
            'label' ,
            'emoji' ,
            'video'
        ];
}
