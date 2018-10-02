<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'cantidad', 'precio', 'es_insumo', 'categoria_id'];
}
