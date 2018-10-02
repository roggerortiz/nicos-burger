<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function graficas()
    {
        if(!request()->ajax()) {
            return redirect()->route('inicio');
        }

        $cantidad = Registro::get()->count();

        $registros = Registro::orderBy('fecha', 'asc')->offset($cantidad - 2)->limit(2)->get();

        $categorias = $registros->pluck('fecha')->toArray();

        $ingresos = $registros->pluck('ingresos')->toArray();

        $egresos = $registros->pluck('egresos')->toArray();

        $productos = Producto::select(DB::raw('productos.nombre as name, IFNULL(SUM(movimientos.cantidad), 0) as y'))
            ->leftJoin('movimientos', 'movimientos.producto_id', '=', 'productos.id')
            ->where('productos.categoria_id', 1)
            ->orderBy('productos.nombre', 'asc')
            ->groupBy('productos.nombre')->get();

        $productos->first()->sliced = true;
        $productos->first()->selected = true;

        return [
            'movimientos' => [
                'categorias' => $categorias,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
            ],
            'productos' => $productos->toArray()
        ];
    }
}
