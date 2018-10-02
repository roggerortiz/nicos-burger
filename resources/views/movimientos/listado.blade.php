<div class="box box-primary">
    <div class="box-header with-border">
        <form class="form-inline form-inline-box">
            <select id="lista_mov" class="form-control">
                <option value="venta"{{ ($tipo == 'venta') ? ' selected' : '' }}>Ventas</option>
                <option value="compra"{{ ($tipo == 'compra') ? ' selected' : '' }}>Compras</option>
                <option value="gasto"{{ ($tipo == 'gasto') ? ' selected' : '' }}>Gastos</option>
            </select>
        </form>
        <div class="box-tools pull-right">
            <a href="{{ route('registros') }}" class="btn btn-success btn-sm btn-box-inline">
                <i class="fa fa-arrow-circle-left"></i><span class="hidden-xs">&nbsp;&nbsp;&nbsp;Volver</span>
            </a>&nbsp;&nbsp;
            <a href="{{ route('registros.reporte', ['id' => $registro->id]) }}" target="_blank" class="btn btn-danger btn-sm btn-box-inline" title="Reporte">
                <i class="fa fa-file-pdf-o"></i><span class="hidden-xs">&nbsp;&nbsp;&nbsp;Reporte</span>
            </a>&nbsp;&nbsp;
            <button type="button" id="btn-nuevo" class="btn btn-primary btn-sm btn-box-inline" data-toggle="modal" data-target="#modalMovimiento">
                <i class="fa fa-plus-circle"></i><span class="hidden-xs">&nbsp;&nbsp;&nbsp;Nuevo</span>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div>
            <span class="hidden-xs">&nbsp;</span>

            <b>Fecha:&nbsp;&nbsp;&nbsp;</b>{{ $registro->fecha }}
            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>

            <b>Ingresos:&nbsp;&nbsp;&nbsp;</b>S/ {{ $registro->ingresos }}
            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>

            <b>Egresos:&nbsp;&nbsp;&nbsp;</b>S/ {{ $registro->egresos }}
        </div>

        <hr style="margin: 10px 0;">

        <div class="table-responsive" id="table-movimientos">
            <table class="table table-bordered table-condensed table-hover table-no-margin">
                <thead>
                <tr>
                    <th>{{ (is_null($tipo) or $tipo == 'venta') ? 'Producto' : (($tipo == 'compra') ? 'Insumo' : 'Descripción') }}</th>
                    @if($tipo != 'gasto')
                    <th>Cantidad</th>
                    @endif
                    <th>Monto</th>
                    @if($tipo != 'gasto')
                    <th>Total</th>
                    @endif
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->descripcion }}</td>
                        @if($tipo != 'gasto')
                        <td class="text-center">{{ $movimiento->cantidad }}</td>
                        @endif
                        <td class="text-center">{{ $movimiento->monto }}</td>
                        @if($tipo != 'gasto')
                        <td class="text-center">{{ $movimiento->total }}</td>
                        @endif
                        <td class="action">
                            <button type="button" class="btn btn-warning btn-editar btn-sm" title="Editar" data-toggle="modal" data-target="#modalMovimiento" data-id="{{ $movimiento->id }}" data-signo="{{ $movimiento->signo }}" data-gasto="{{ $movimiento->es_gasto }}" data-cant="{{ $movimiento->cantidad }}" data-descrip="{{ $movimiento->descripcion }}" data-monto="{{ $movimiento->monto }}" data-prod="{{ $movimiento->producto_id }}">
                                <span class="fa fa-pencil-square-o"></span>
                            </button>
                        </td>
                        <td class="action">
                            <button type="button" class="btn btn-danger btn-eliminar btn-sm" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="{{ $movimiento->id }}">
                                <span class="fa fa-trash-o"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if($movimientos->count() == 0)
                    <tr>
                        <td class="text-center" colspan="{{ ($tipo == 'gasto') ? '4' :'6' }}">
                            No se encontraron {{ (is_null($tipo) or $tipo == 'venta') ? 'ventas registradas' : (($tipo == 'compra') ? 'compras registradas' : 'gastos registrados') }}.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer text-center{{ ($movimientos->lastPage() == 1) ? ' hidden' : '' }}">
        {{ $movimientos->links() }}
    </div>
</div>
