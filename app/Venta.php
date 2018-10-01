<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['producto', 'cantidad', 'precio', 'producto_id', 'registro_id'];

    public function getTotalAttribute()
    {
        return number_format($this->attributes['cantidad'] * $this->attributes['precio'], 2);
    }
}
