<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumoProducto extends Model
{
    protected $table = 'insumo_producto';
    protected $fillable = ['cantidad', 'insumo_id', 'producto_id'];
}
