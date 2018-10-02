<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Registro;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function actualizar_totales($registro_id)
    {
        $ingresos = Movimiento::where('signo', '1')->where('registro_id', $registro_id)->get()->sum('total');
        $egresos = Movimiento::where('signo', '-1')->where('registro_id', $registro_id)->get()->sum('total');

        $registro = Registro::find($registro_id);
        $registro->ingresos = $ingresos;
        $registro->egresos = $egresos;
        $registro->total = $ingresos - $egresos;
        $registro->save();
    }
}
