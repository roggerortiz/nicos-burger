<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Insumos</h3>
        <div class="box-tools pull-right">
            <button type="button" id="btn-nuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalInsumo">
                <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Nuevo
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive" id="table-insumos">
            <table class="table table-bordered table-condensed table-hover table-no-margin">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($insumos as $insumo)
                    <tr>
                        <td>{{ $insumo->nombre }}</td>
                        <td class="text-center">{{ $insumo->precio }}</td>
                        <td class="action">
                            <button type="button" class="btn btn-warning btn-editar btn-sm" title="Editar" data-toggle="modal" data-target="#modalInsumo" data-id="{{ $insumo->id }}" data-nomb="{{ $insumo->nombre }}" data-precio="{{ $insumo->precio }}">
                                <span class="fa fa-pencil-square-o"></span>
                            </button>
                        </td>
                        <td class="action">
                            <button type="button" class="btn btn-danger btn-eliminar btn-sm" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="{{ $insumo->id }}">
                                <span class="fa fa-trash-o"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if($insumos->count() == 0)
                    <tr>
                        <td class="text-center" colspan="4">
                            No se encontraron insumos registrados.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer text-center{{ ($insumos->lastPage() == 1) ? ' hidden' : '' }}">
        {{ $insumos->links() }}
    </div>
</div>
