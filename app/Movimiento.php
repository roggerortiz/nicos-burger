<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = ['descripcion', 'cantidad', 'monto', 'signo', 'es_gasto', 'producto_id', 'registro_id'];

    public function getTotalAttribute()
    {
        return number_format($this->attributes['cantidad'] * $this->attributes['monto'], 2);
    }
}
