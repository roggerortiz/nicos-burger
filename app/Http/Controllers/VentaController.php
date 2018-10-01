<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Venta;

class VentaController extends Controller
{
    public function crear()
    {
        $this->validate(request(), [
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ], [
            'producto_id.required' => 'Este campo es requerido',
            'producto_id.integer' => 'Este campo debe ser entero',
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
        ]);

        $producto = Producto::find(request('producto_id'));

        if(is_null($producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Producto no registrado.'
                ]
            ]];
        }

        Venta::create([
            'producto' => $producto->nombre,
            'cantidad' => request('cantidad'),
            'precio' => $producto->precio,
            'producto_id' => $producto->id,
            'registro_id' => request('registro_id'),
        ]);

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ], [
            'producto_id.required' => 'Este campo es requerido',
            'producto_id.integer' => 'Este campo debe ser entero',
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
        ]);

        $producto = Producto::find(request('producto_id'));

        if(is_null($producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Producto no registrado.'
                ]
            ]];
        }

        $venta = Venta::find(request('venta_id'));

        if(is_null($venta)) {
            return ['success' => false, 'errors' => [
                'venta_id' => [
                    'Venta no registrada.'
                ]
            ]];
        }

        $venta->fill(request()->all());
        $venta->producto = $producto->nombre;
        $venta->save();

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function eliminar()
    {
        $venta = Venta::find(request('venta_id'));

        if(is_null($venta)) {
            return ['success' => false, 'errors' => [
                'venta_id' => [
                    'Venta no registrada.'
                ]
            ]];
        }

        $venta->delete();

        $this->actualizar_totales($venta->registro_id);

        return ['success' => true];
    }
}
