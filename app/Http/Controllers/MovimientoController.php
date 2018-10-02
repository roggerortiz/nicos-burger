<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Producto;
use App\Registro;

class MovimientoController extends Controller
{
    public function index($registro_id)
    {
        $registro = Registro::find($registro_id);

        if(is_null($registro)) {
            return redirect()->route('registros');
        }

        $tipo = request('tipo');

        $condicion = 'true';

        if(is_null($tipo) or $tipo == 'venta'){
            $condicion = 'signo = 1 and es_gasto = false';
        } elseif ($tipo == 'compra') {
            $condicion = 'signo = -1 and es_gasto = false';
        } elseif ($tipo == 'gasto') {
            $condicion = 'signo = -1 and es_gasto = true';
        }

        $movimientos = Movimiento::whereRaw($condicion)->where('registro_id', $registro_id)->paginate(10);

        if(request()->ajax()) {
            return view('movimientos.listado', compact('tipo', 'movimientos', 'registro'));
        }

        if(!is_null($tipo)) {
            return redirect()->route('registros.movimientos', ['id' => $registro->id]);
        }

        $productos = Producto::distinct()->select('productos.*')->where('es_insumo', false)
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->orderBy('categorias.id', 'asc')->orderBy('productos.nombre', 'asc')->get();

        $insumos = Producto::where('es_insumo', true)->orderBy('nombre', 'asc')->get();

        $page = request('page');

        return view('movimientos.index', compact('tipo', 'movimientos', 'registro', 'productos', 'insumos', 'page'));
    }

    public function eliminar()
    {
        $movimiento = Movimiento::find(request('movimiento_id'));

        if(is_null($movimiento)) {
            return ['success' => false, 'errors' => [
                'movimiento_id' => [
                    'Movimiento no registrada.'
                ]
            ]];
        }

        $movimiento->delete();

        $this->actualizar_totales($movimiento->registro_id);

        return ['success' => true];
    }
}
