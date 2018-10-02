<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = ['descripcion', 'cantidad', 'precio', 'total', 'signo', 'es_gasto', 'producto_id', 'registro_id'];
}
