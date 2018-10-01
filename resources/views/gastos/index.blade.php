<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Gastos</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('inicio') }}" class="btn btn-success btn-sm">
                <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;&nbsp;Volver
            </a>&nbsp;&nbsp;
            <button type="button" id="btn-nuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalGasto">
                <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Nuevo
            </button>
        </div>
    </div>
    <div class="box-body">
        <div>
            <span class="hidden-xs">&nbsp;</span>

            <b>Fecha:&nbsp;&nbsp;&nbsp;</b>{{ $registro->fecha }}
            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>

            <b>Ventas:&nbsp;&nbsp;&nbsp;</b>S/ {{ $registro->ventas }}
            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>

            <b>Gastos:&nbsp;&nbsp;&nbsp;</b>S/ {{ $registro->gastos }}
        </div>

        <hr style="margin: 10px 0;">

        <div class="table-responsive" id="table-ventas">
            <table class="table table-bordered table-condensed table-hover table-no-margin">
                <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($gastos as $gasto)
                    <tr>
                        <td>{{ $gasto->descripcion }}</td>
                        <td class="text-center">{{ $gasto->monto }}</td>
                        <td class="action">
                            <button type="button" class="btn btn-warning btn-editar btn-sm" title="Editar" data-toggle="modal" data-target="#modalGasto" data-id="{{ $gasto->id }}" data-descrip="{{ $gasto->descripcion }}" data-monto="{{ $gasto->monto }}">
                                <span class="fa fa-pencil-square-o"></span>
                            </button>
                        </td>
                        <td class="action">
                            <button type="button" class="btn btn-danger btn-eliminar btn-sm" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="{{ $gasto->id }}">
                                <span class="fa fa-trash-o"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if($gastos->count() == 0)
                    <tr>
                        <td class="text-center" colspan="4">
                            No se encontraron gastos registrados.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer text-center{{ ($gastos->lastPage() == 1) ? ' hidden' : '' }}">
        {{ $gastos->links() }}
    </div>
</div>
