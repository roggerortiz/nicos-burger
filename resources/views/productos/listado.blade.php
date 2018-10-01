<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Productos</h3>
        <div class="box-tools pull-right">
            <button type="button" id="btn-nuevo" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalProducto">
                <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Nuevo
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive" id="table-productos">
            <table class="table table-bordered table-condensed table-hover table-no-margin">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td class="text-center">{{ $producto->precio }}</td>
                        <td class="text-center">{{ $producto->categoria }}</td>
                        <td class="action">
                            <button type="button" class="btn btn-success btn-insumos btn-sm" title="Insumos" data-id="{{ $producto->id }}">
                                <span class="fa fa-apple"></span>
                            </button>
                        </td>
                        <td class="action">
                            <button type="button" class="btn btn-warning btn-editar btn-sm" title="Editar" data-toggle="modal" data-target="#modalProducto" data-id="{{ $producto->id }}" data-nomb="{{ $producto->nombre }}" data-precio="{{ $producto->precio }}" data-cat="{{ $producto->categoria_id }}">
                                <span class="fa fa-pencil-square-o"></span>
                            </button>
                        </td>
                        <td class="action">
                            <button type="button" class="btn btn-danger btn-eliminar btn-sm" title="Eliminar" data-toggle="modal" data-target="#modalEliminar" data-id="{{ $producto->id }}">
                                <span class="fa fa-trash-o"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if($productos->count() == 0)
                    <tr>
                        <td class="text-center" colspan="6">
                            No se encontraron productos registrados.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer text-center{{ ($productos->lastPage() == 1) ? ' hidden' : '' }}">
        {{ $productos->links() }}
    </div>
</div>
