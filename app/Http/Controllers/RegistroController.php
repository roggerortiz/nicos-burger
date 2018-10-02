<?php

namespace App\Http\Controllers;

use App;
use App\Categoria;
use App\Insumo;
use App\Movimiento;
use App\Producto;
use App\Registro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function index()
    {
        $registros = Registro::orderBy('fecha', 'desc')->paginate(10);

        if(request()->ajax()) {
            return view('registros.listado', compact('registros'));
        }

        $page = request('page');

        return view('registros.index', compact('registros', 'page'));
    }

    public function crear()
    {
        $ahora = Carbon::parse(date('Y-m-d') . ' 00:00');
        $fecha = Carbon::parse(request('fecha'));

        if ($fecha->diffInDays($ahora, false) < 0) {
            return ['success' => false, 'message' => 'Fecha no permitida.'];
        }

        $registro = Registro::where('fecha', request('fecha'))->first();

        if (!is_null($registro)) {
            return ['success' => false, 'message' => 'Fecha ya registrada.'];
        }

        Registro::create(request()->all());

        session()->flash('success', 'Registro Exitoso');

        return ['success' => true];
    }

    public function reporte($registro_id)
    {
        $registro = Registro::find($registro_id);

        $categorias = Categoria::all();

        foreach ($categorias as $categoria) {
            $categoria->ventas = Movimiento::select('movimientos.*')
                ->join('productos', 'productos.id', '=', 'movimientos.producto_id')
                ->where('productos.categoria_id', $categoria->id)
                ->where('movimientos.registro_id', $registro_id)
                ->where('signo', '1')->get();
        }

        $compras = Movimiento::where('signo', '-1')->where('es_gasto', false)
            ->where('movimientos.registro_id', $registro_id)->get();

        $gastos = Movimiento::where('signo', '-1')->where('es_gasto', true)
            ->where('registro_id', $registro_id)->get();

        $insumos = Producto::select(DB::raw('productos.id, productos.nombre, SUM(insumo_producto.cantidad * movimientos.cantidad) as cantidad_consumida'))
            ->join('insumo_producto', 'insumo_producto.insumo_id', '=', 'productos.id')
            ->join('productos as productosp', 'productosp.id', '=', 'insumo_producto.producto_id')
            ->join('movimientos', 'movimientos.producto_id', '=', 'productosp.id')
            ->where('movimientos.registro_id', $registro_id)->where('productos.es_insumo', true)
            ->groupBy('productos.id')->groupBy('productos.nombre')->get();

        foreach ($insumos as $insumo) {
            $insumo->cantidad_inicial = Movimiento::where('signo', '-1')->where('es_gasto', false)
                ->where('registro_id', $registro->id)->where('producto_id', $insumo->id)->sum('cantidad');
            $insumo->cantidad_final = $insumo->cantidad_inicial - $insumo->cantidad_consumida;
            if($insumo->cantidad_final < 0) $insumo->cantidad_final = 0;
        }

        // return view('registros.reporte', compact('registro', 'categorias', 'compras', 'gastos', 'insumos'));

        $view = view('registros.reporte', compact('registro', 'categorias', 'compras', 'gastos', 'insumos'))->render();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }
}
