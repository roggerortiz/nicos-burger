<?php

namespace App\Http\Controllers;

use App;
use App\Categoria;
use App\Gasto;
use App\Insumo;
use App\Producto;
use App\Registro;
use App\Venta;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function index()
    {
        $registros = Registro::orderBy('fecha', 'desc')->paginate(1);

        if(request()->ajax()) {
            return view('registros.listado', compact('registros'));
        }

        $page = request('page');

        return view('registros.index', compact('registros', 'page'));
    }

    public function reporte($registro_id)
    {
        $registro = Registro::find($registro_id);

        $categorias = Categoria::all();

        foreach ($categorias as $categoria) {
            $categoria->ventas = Venta::select('ventas.*')
                ->join('productos', 'productos.id', '=', 'ventas.producto_id')
                ->where('productos.categoria_id', $categoria->id)
                ->where('ventas.registro_id', $registro_id)->get();
        }

        $gastos = Gasto::where('registro_id', $registro_id)->get();

        $insumos = Insumo::distinct()->select(DB::raw('insumos.nombre, SUM(insumo_producto.cantidad) as cantidad'))
            ->join('insumo_producto', 'insumo_producto.insumo_id', '=', 'insumos.id')
            ->join('productos', 'productos.id', '=', 'insumo_producto.producto_id')
            ->join('ventas', 'ventas.producto_id', '=', 'productos.id')
            ->where('ventas.registro_id', $registro_id)
            ->groupBy('insumos.nombre')->groupBy('insumo_producto.cantidad')->get();

        // return view('registros.reporte', compact('registro', 'ventas', 'gastos', 'insumos'));

        $view = view('registros.reporte', compact('registro', 'categorias', 'gastos', 'insumos'))->render();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    public function ventas($registro_id)
    {
        $registro = Registro::find($registro_id);

        $ventas = Venta::where('registro_id', $registro_id)->paginate(10);

        if(request()->ajax()) {
            return view('ventas.index', compact('ventas', 'registro'));
        }

        $productos = Producto::orderBy('nombre', 'asc')->get();

        $page = request('page');

        return view('registros.ventas', compact('ventas', 'productos', 'registro', 'page'));
    }

    public function gastos($registro_id)
    {
        $registro = Registro::find($registro_id);

        $gastos = Gasto::where('registro_id', $registro_id)->paginate(10);

        if(request()->ajax()) {
            return view('gastos.index', compact('gastos', 'registro'));
        }

        $page = request('page');

        return view('registros.gastos', compact('gastos', 'registro', 'page'));
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
}
