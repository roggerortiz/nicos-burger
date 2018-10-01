<?php

namespace App\Http\Controllers;

use App\Gasto;
use App\Registro;
use App\Venta;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function actualizar_totales($registro_id)
    {
        $total_ventas = Venta::where('registro_id', $registro_id)->get()->sum('total');
        $total_gastos = Gasto::where('registro_id', $registro_id)->get()->sum('monto');

        $registro = Registro::find($registro_id);
        $registro->ventas = $total_ventas;
        $registro->gastos = $total_gastos;
        $registro->ganancia = $total_ventas - $total_gastos;
        $registro->save();
    }
}
