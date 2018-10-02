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
        ], [
            'nombre.required' => 'Este campo es requerido',
        ]);

        Producto::create([
            'nombre' => request('nombre'),
            'precio' => (request('precio') > 0) ? request('precio') : null,
            'es_insumo' => true,
        ]);

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'nombre' => 'required',
        ], [
            'nombre.required' => 'Este campo es requerido',
        ]);

        $insumo = Producto::find(request('insumo_id'));

        if(is_null($insumo)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Insumo no registrado.'
                ]
            ]];
        }

        $insumo->fill([
            'nombre' => request('nombre'),
            'precio' => (request('precio') > 0) ? request('precio') : null,
            'es_insumo' => true,
        ]);
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
