<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Historial de Registros</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#modalRegistro">
                <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Nuevo
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover table-no-margin">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Ventas</th>
                    <th>Gastos</th>
                    <th>Ganancia</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($registros as $registro)
                    <tr>
                        <td class="text-center">{{ $registro->fecha }}</td>
                        <td class="text-center">{{ $registro->ventas }}</td>
                        <td class="text-center">{{ $registro->gastos }}</td>
                        <td class="text-center">{{ $registro->ganancia }}</td>
                        <td class="action">
                            <a href="{{ route('registros.ventas', ['id' => $registro->id]) }}" class="btn btn-success btn-sm" title="Ventas">
                                <span class="fa fa-money"></span>
                            </a>
                        </td>
                        <td class="action">
                            <a href="{{ route('registros.gastos', ['id' => $registro->id]) }}" class="btn btn-warning btn-sm" title="Gastos">
                                <span class="fa fa-arrow-circle-o-down"></span>
                            </a>
                        </td>
                        <td class="action">
                            <a href="{{ route('registros.reporte', ['id' => $registro->id]) }}" target="_blank" class="btn btn-danger btn-sm" title="Reporte">
                                <span class="fa fa-file-pdf-o"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

                @if($registros->count() == 0)
                    <tr>
                        <td class="text-center" colspan="7">
                            No se encontraron movimientos registrados.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer text-center{{ ($registros->lastPage() == 1) ? ' hidden' : '' }}">
        {{ $registros->links() }}
    </div>
</div>
