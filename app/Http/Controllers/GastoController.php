<?php

namespace App\Http\Controllers;

use App\Movimiento;

class GastoController extends Controller
{
    public function crear()
    {
        $this->validate(request(), [
            'descripcion' => 'required',
            'monto' => 'required|numeric|min:0.0001',
            'registro_id' => 'required|integer|exists:registros,id',
        ], [
            'descripcion.required' => 'Este campo es requerido',
            'monto.required' => 'Este campo es requerido',
            'monto.numeric' => 'Este campo debe ser decimal',
            'monto.min' => 'El valor de este campo debe ser mayor a 0',
            'registro_id.required' => 'Este campo es requerido',
            'registro_id.integer' => 'Este campo debe ser entero',
            'registro_id.exists' => 'Registro no encontrado',
        ]);

        Movimiento::create([
            'descripcion' => request('descripcion'),
            'monto' => request('monto'),
            'signo' => '-1',
            'es_gasto' => true,
            'registro_id' => request('registro_id'),
        ]);

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'descripcion' => 'required',
            'monto' => 'required|numeric|min:0.0001',
            'movimiento_id' => 'required|integer|exists:movimientos,id',
        ], [
            'descripcion.required' => 'Este campo es requerido',
            'monto.required' => 'Este campo es requerido',
            'monto.numeric' => 'Este campo debe ser decimal',
            'monto.min' => 'El valor de este campo debe ser mayor a 0',
            'movimiento_id.required' => 'Este campo es requerido',
            'movimiento_id.integer' => 'Este campo debe ser entero',
            'movimiento_id.exists' => 'Movimiento no encontrado',
        ]);

        $gasto = Movimiento::find(request('movimiento_id'));
        $gasto->fill([
            'descripcion' => request('descripcion'),
            'monto' => request('monto'),
        ]);
        $gasto->save();

        $this->actualizar_totales($gasto->registro_id);

        return ['success' => true];
    }
}
