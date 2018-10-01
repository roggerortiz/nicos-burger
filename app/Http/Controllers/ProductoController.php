<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::select('productos.*', 'categorias.nombre as categoria')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->orderBy('categorias.id', 'asc')->orderBy('productos.nombre', 'asc')
            ->paginate(10);

        if(request()->ajax()) {
            return view('productos.listado', compact('productos'));
        }

        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        $page = request('page');

        return view('productos.index', compact('productos', 'categorias', 'page'));
    }

    public function crear()
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0.0001',
            'categoria_id' => 'required|integer',
        ], [
            'nombre.required' => 'Este campo es requerido',
            'precio.required' => 'Este campo es requerido',
            'precio.numeric' => 'Este campo debe ser decimal',
            'precio.min' => 'El valor de este campo debe ser mayor a 0',
            'categoria_id.required' => 'Este campo es requerido',
            'categoria_id.integer' => 'Este campo debe ser entero',
        ]);

        Producto::create(request()->all());

        return ['success' => true];
    }

    public function editar()
    {
        $this->validate(request(), [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0.0001',
            'categoria_id' => 'required|integer',
        ], [
            'nombre.required' => 'Este campo es requerido',
            'precio.required' => 'Este campo es requerido',
            'precio.numeric' => 'Este campo debe ser decimal',
            'precio.min' => 'El valor de este campo debe ser mayor a 0',
            'categoria_id.required' => 'Este campo es requerido',
            'categoria_id.integer' => 'Este campo debe ser entero',
        ]);

        $producto = Producto::find(request('producto_id'));

        if(is_null($producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Producto no registrado.'
                ]
            ]];
        }

        $producto->fill(request()->all());
        $producto->save();

        return ['success' => true];
    }

    public function eliminar()
    {
        $producto = Producto::find(request('producto_id'));

        if(is_null($producto)) {
            return ['success' => false, 'errors' => [
                'producto_id' => [
                    'Producto no registrado.'
                ]
            ]];
        }

        $producto->delete();

        return ['success' => true];
    }
}
