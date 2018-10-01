<div class="modal-content" id="content-ins-table">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Insumos de {{ $producto->nombre }}</h4>
    </div>
    <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover table-no-margin">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($producto->insumos as $insumo)
                    <tr>
                        <td>{{ $insumo->nombre }}</td>
                        <td class="text-center">{{ $insumo->cantidad }}</td>
                        <td class="action">
                            <button type="button" class="btn btn-warning btn-ins-editar btn-sm" title="Editar" data-id="{{ $insumo->id }}" data-ins="{{ $insumo->insumo_id }}" data-cant="{{ $insumo->cantidad }}">
                                <span class="fa fa-pencil-square-o"></span>
                            </button>
                        </td>
                        <td class="action">
                            <button type="button" class="btn btn-danger btn-ins-quitar btn-sm" title="Eliminar" data-id="{{ $insumo->id }}">
                                <span class="fa fa-trash-o"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if($producto->insumos->count() == 0)
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
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn-ins-agregar" class="btn btn-primary">Nuevo</button>
    </div>
</div>

<div class="modal-content hidden" id="content-ins-form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalInsumoLabel"></h4>
    </div>
    <div class="modal-body">
        <form id="form-insumo" action="">
            @csrf
            <input type="hidden" name="insumo_producto_id" id="insumo_producto_id">
            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            <div class="form-group">
                <label>Insumo:</label>
                <select id="insumo_id" name="insumo_id" class="form-control">
                    <option value="">- Seleccionar Insumo -</option>
                    @foreach($insumos as $insumo)
                        <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" min="1" class="form-control" placeholder="Cantidad">
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-cerrar-ins">Cerrar</button>
        <button type="button" id="btn-ins-guardar" class="btn btn-primary">Guardar</button>
    </div>
</div>

<div class="modal-content hidden" id="content-ins-eliminar">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Quitar Insumo</h4>
    </div>
    <div class="modal-body">
        <p class="text-justify">¿Está seguro que desea quitar este insumo?</p>
        <form id="form-ins-quitar" action="{{ route('productos.insumos.quitar', ['id' => '%']) }}" class="hidden">
            @csrf
            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            <input type="hidden" name="insumo_producto_id" id="delete_insumo_id">
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-cerrar-ins">No</button>
        <button type="button" id="btn-ins-conf-quitar" class="btn btn-danger">Si</button>
    </div>
</div>
