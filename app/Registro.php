<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $fillable = ['fecha', 'ventas', 'gastos', 'ganancia'];

    public function getFechaAttribute()
    {
        return Carbon::parse($this->attributes['fecha'])->format('d/m/Y');
    }

    public function getDiaAttribute()
    {
        $dias = [
            'Mon' => 'Lunes', 'Tue' => 'Martes', 'Wed' => 'Miércoles',
            'Thu' => 'Jueves', 'Fri' => 'Viernes', 'Sat' => 'Sábado', 'Sun' => 'Domingo'
        ];

        return $dias[Carbon::parse($this->attributes['fecha'])->format('D')];
    }
}
