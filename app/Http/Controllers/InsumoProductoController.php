<?php

namespace App\Http\Controllers;

use App\Insumo;
use App\InsumoProducto;
use App\Producto;

class InsumoProductoController extends Controller
{
    public function index($producto_id)
    {
        if(!request()->ajax()) {
            return redirect()->route('productos');
        }

        $producto = Producto::find($producto_id);

        $producto->insumos = Producto::select('insumo_producto.id', 'productos.nombre', 'insumo_producto.cantidad', 'productos.id as insumo_id')
            ->join('insumo_producto', 'insumo_producto.insumo_id', '=', 'productos.id')
            ->where('insumo_producto.producto_id', $producto_id)
            ->where('productos.es_insumo', true)->get();

        $ids= $producto->insumos->pluck('id')->toArray();

        $insumos = Producto::orderBy('nombre', 'asc')->where('es_insumo', true)->get()->reject(function ($insumo) use ($ids) {
            return in_array($insumo->id, $ids);
        });

        return view('productos.insumos', compact('producto', 'insumos'));
    }

    public function agregar()
    {
        $this->validate(request(), [
            'cantidad' => 'required|integer|min:1',
            'insumo_id' => 'required|integer',
            'producto_id' => 'required|integer',
        ], [
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
            'insumo_id.required' => 'Este campo es requerido',
            'insumo_id.integer' => 'Este campo debe ser entero',
            'producto_id.required' => 'Este campo es requerido',
            'producto_id.integer' => 'Este campo debe ser entero',
        ]);

        $insumo_producto = InsumoProducto::where('insumo_id', request('insumo_id'))
            ->where('producto_id', request('producto_id'))->first();

        if(!is_null($insumo_producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Insumo ya agregado.'
                ]
            ]];
        }

        InsumoProducto::create(request()->all());

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'cantidad' => 'required|integer|min:1',
            'insumo_producto_id' => 'required|integer',
        ], [
            'cantidad.required' => 'Este campo es requerido',
            'cantidad.integer' => 'Este campo debe ser entero',
            'cantidad.min' => 'El valor mínimo de este campo es 1',
            'insumo_producto_id.required' => 'Este campo es requerido',
            'insumo_producto_id.integer' => 'Este campo debe ser entero',
        ]);

        $insumo_producto = InsumoProducto::find(request('insumo_producto_id'));

        if(is_null($insumo_producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Insumo no agregado.'
                ]
            ]];
        }

        $insumo_producto->cantidad = request('cantidad');
        $insumo_producto->save();

        return ['success' => true];
    }

    public function quitar()
    {
        $insumo_producto = InsumoProducto::find(request('insumo_producto_id'));

        if(is_null($insumo_producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Insumo no agregado.'
                ]
            ]];
        }

        $insumo_producto->delete();

        return ['success' => true];
    }

}
