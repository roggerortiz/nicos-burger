<?php

namespace App\Http\Controllers;

use App\InsumoProducto;
use App\Movimiento;
use App\Producto;

class VentaController extends Controller
{
    public function crear()
    {
        $this->validate(request(), [
            'cantidad' => 'required|integer|min:1',
            'producto_id' => 'required|integer|exists:productos,id',
            'registro_id' => 'required|integer|exists:registros,id',
        ], [
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
            'producto_id.required' => 'Este campo es requerido',
            'producto_id.integer' => 'Este campo debe ser entero',
            'producto_id.exists' => 'Producto no encontrado',
            'registro_id.required' => 'Este campo es requerido',
            'registro_id.integer' => 'Este campo debe ser entero',
            'registro_id.exists' => 'Registro no encontrado',
        ]);

        $producto = Producto::find(request('producto_id'));

        Movimiento::create([
            'descripcion' => $producto->nombre,
            'cantidad' => request('cantidad'),
            'precio' => $producto->precio,
            'total' => request('cantidad') * $producto->precio,
            'signo' => '1',
            'producto_id' => $producto->id,
            'registro_id' => request('registro_id'),
        ]);

        $this->actualizar_totales(request('registro_id'));

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'cantidad' => 'required|integer|min:1',
            'movimiento_id' => 'required|integer|exists:movimientos,id',
        ], [
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
            'movimiento_id.required' => 'Este campo es requerido',
            'movimiento_id.integer' => 'Este campo debe ser entero',
            'movimiento_id.exists' => 'Movimiento no encontrado',
        ]);

        $producto = Producto::find(request('producto_id'));

        $venta = Movimiento::find(request('movimiento_id'));
        $venta->fill([
            'cantidad' => request('cantidad'),
            'total' => request('cantidad') * $producto->precio,
        ]);
        $venta->save();

        $this->actualizar_totales($venta->registro_id);

        return ['success' => true];
    }
}
