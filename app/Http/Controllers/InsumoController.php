<?php

namespace App\Http\Controllers;

use App\Producto;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Producto::where('es_insumo', true)->orderBy('nombre', 'asc')->paginate(10);

        if(request()->ajax()) {
            return view('insumos.listado', compact('insumos'));
        }

        $page = request('page');

        return view('insumos.index', compact('insumos', 'page'));
    }

    public function crear()
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0.0001',
        ], [
            'nombre.required' => 'Este campo es requerido',
            'precio.required' => 'Este campo es requerido',
            'precio.numeric' => 'Este campo debe ser decimal',
            'precio.min' => 'El valor de este campo debe ser mayor a 0',
        ]);

        Producto::create([
            'nombre' => request('nombre'),
            'precio' => request('precio'),
            'es_insumo' => true,
        ]);

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0.0001',
        ], [
            'nombre.required' => 'Este campo es requerido',
            'precio.required' => 'Este campo es requerido',
            'precio.numeric' => 'Este campo debe ser decimal',
            'precio.min' => 'El valor de este campo debe ser mayor a 0',
        ]);

        $insumo = Producto::find(request('insumo_id'));

        if(is_null($insumo)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Insumo no registrado.'
                ]
            ]];
        }

        $insumo->fill(request()->all());
        $insumo->save();

        return ['success' => true];
    }

    public function eliminar()
    {
        $insumo = Producto::find(request('insumo_id'));

        if(is_null($insumo)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Insumo no registrado.'
                ]
            ]];
        }

        $insumo->delete();

        return ['success' => true];
    }

}
