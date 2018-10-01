<?php

namespace App\Http\Controllers;

use App\Gasto;

class GastoController extends Controller
{
    public function crear()
    {
        $this->validate(request(), [
            'descripcion' => 'required',
            'monto' => 'required|numeric|min:0.0001',
        ], [
            'descripcion.required' => 'Este campo es requerido',
            'monto.required' => 'Este campo es requerido',
            'monto.numeric' => 'Este campo debe ser decimal',
            'monto.min' => 'El valor de este campo debe ser mayor a 0',
        ]);

        Gasto::create(request()->all());

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'descripcion' => 'required',
            'monto' => 'required|numeric|min:0.0001',
        ], [
            'descripcion.required' => 'Este campo es requerido',
            'monto.required' => 'Este campo es requerido',
            'monto.numeric' => 'Este campo debe ser decimal',
            'monto.min' => 'El valor de este campo debe ser mayor a 0',
        ]);

        $gasto = Gasto::find(request('gasto_id'));

        if(is_null($gasto)) {
            return ['success' => false, 'errors' => [
                'gasto_id' => [
                    'Gasto no registrado.'
                ]
            ]];
        }

        $gasto->fill(request()->all());
        $gasto->save();

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function eliminar()
    {
        $gasto = Gasto::find(request('gasto_id'));

        if(is_null($gasto)) {
            return ['success' => false, 'errors' => [
                'gasto_id' => [
                    'Gasto no registrado.'
                ]
            ]];
        }

        $gasto->delete();

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }
}
