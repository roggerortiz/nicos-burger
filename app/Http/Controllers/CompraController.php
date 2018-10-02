<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Producto;

class CompraController extends Controller
{
    public function crear()
    {
        $this->validate(request(), [
            'cantidad' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0.0001',
            'insumo_id' => 'required|integer|exists:productos,id',
            'registro_id' => 'required|integer|exists:registros,id',
        ], [
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
            'total.required' => 'Este campo es requerido',
            'total.numeric' => 'Este campo debe ser decimal',
            'total.min' => 'El valor de este campo debe ser mayor a 0',
            'insumo_id.required' => 'Este campo es requerido',
            'insumo_id.integer' => 'Este campo debe ser entero',
            'insumo_id.exists' => 'Insumo no encontrado',
            'registro_id.required' => 'Este campo es requerido',
            'registro_id.integer' => 'Este campo debe ser entero',
            'registro_id.exists' => 'Registro no encontrado',
        ]);

        $insumo = Producto::find(request('insumo_id'));

        Movimiento::create([
            'descripcion' => $insumo->nombre,
            'cantidad' => request('cantidad'),
            'precio' => request('total') /request('cantidad'),
            'total' => request('total'),
            'signo' => '-1',
            'producto_id' => $insumo->id,
            'registro_id' => request('registro_id'),
        ]);

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'cantidad' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0.0001',
            'movimiento_id' => 'required|integer|exists:movimientos,id',
        ], [
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
            'total.required' => 'Este campo es requerido',
            'total.numeric' => 'Este campo debe ser decimal',
            'total.min' => 'El valor de este campo debe ser mayor a 0',
            'movimiento_id.required' => 'Este campo es requerido',
            'movimiento_id.integer' => 'Este campo debe ser entero',
            'movimiento_id.exists' => 'Movimiento no encontrado',
        ]);

        $compra = Movimiento::find(request('movimiento_id'));
        $compra->fill([
            'cantidad' => request('cantidad'),
            'precio' => request('total') /request('cantidad'),
            'total' => request('total'),
        ]);
        $compra->save();

        $this->actualizar_totales($compra->registro_id);

        return ['success' => true];
    }
}
