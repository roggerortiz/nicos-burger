@extends('app')

@section('title', 'Productos')

@section('content')
    <div class="row">
        <div id="content-productos" class="col-md-8 col-md-offset-2">
            @include('productos.listado')
        </div>
    </div>

    <div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-labelledby="modalProductoLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalProductoLabel">Nuevo Producto</h4>
                </div>
                <div class="modal-body">
                    <form id="form-producto" action="">
                        @csrf
                        <input type="hidden" name="producto_id" id="producto_id">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label>Precio:</label>
                            <input type="number" id="precio" name="precio" min="0.0001" class="form-control" placeholder="Precio">
                        </div>
                        <div class="form-group">
                            <label>Categoría:</label>
                            <select id="categoria_id" name="categoria_id" class="form-control">
                                <option value="">- Seleccionar Categoría -</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn-guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalEliminarLabel">Eliminar Producto</h4>
                </div>
                <div class="modal-body">
                    <p class="text-justify">¿Está seguro que desea eliminar este producto?</p>
                    <form id="form-eliminar" action="{{ route('productos.eliminar') }}" class="hidden">
                        @csrf
                        <input type="hidden" name="producto_id" id="delete_producto_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" id="btn-conf-eliminar" class="btn btn-danger">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInsumos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.page-link', function () {
            event.preventDefault();
            $('#content-productos').load($(this).attr('href'));
        });

        $(document).on('shown.bs.modal', '#modalProducto', function () {
            $('.label-error').remove();
            $('#nombre').focus().select();
        });

        $(document).on('click', '#btn-nuevo', function () {
            $('.label-error').remove();
            $('#modalProductoLabel').html('Nuevo Producto');
            $('#form-producto').attr('action', '{{ route('productos.crear') }}');
            $('#producto_id').val('');
            $('#nombre').val('');
            $('#precio').val('1.00');
            $('#categoria_id').val('');
        });

        $(document).on('click', '.btn-insumos', function () {
            $('#content-ins-table').removeClass('hidden');
            $('#content-ins-form').addClass('hidden');
            $('#content-ins-eliminar').addClass('hidden');

            $('#modalInsumos .modal-dialog').removeClass('modal-sm');

            var url = '{{ route('productos.insumos', ['id' => '%']) }}'
            url = url.replace('%', $(this).attr('data-id'));

            $('#modalInsumos .modal-dialog').load(url, function () {
                $('#modalInsumos').modal('toggle');
            });
        });

        $(document).on('click', '.btn-editar', function () {
            $('.label-error').remove();
            $('#modalProductoLabel').html('Editar Producto');
            $('#form-producto').attr('action', '{{ route('productos.editar') }}');
            $('#producto_id').val($(this).attr('data-id'));
            $('#nombre').val($(this).attr('data-nomb'));
            $('#precio').val($(this).attr('data-precio'));
            $('#categoria_id').val($(this).attr('data-cat'));
        });

        $(document).on('click', '.btn-eliminar', function () {
            $('#delete_producto_id').val($(this).attr('data-id'));
        });

        $(document).on('click', '#btn-guardar', function () {
            $('.label-error').remove();

            var url = $('#form-producto').attr('action');
            var data = $('#form-producto').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    $('#content-productos').load('{{ route('productos') }}?page={{ $page }}', function () {
                        $('#modalProducto').modal('hide');
                        toastr.success(($('#producto_id').val() > 0) ? 'Producto Actualizado' : 'Producto Registrado');
                    });
                } else {
                    $.each(result.errors, function (indexError, messages) {
                        $.each(messages, function (indexMessage, value) {
                            $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                        });
                    });
                }
            }).fail(function (result) {
                var errors = JSON.parse(result.responseText).errors;

                $.each(errors, function (indexError, messages) {
                    $.each(messages, function (indexMessage, value) {
                        $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                    });
                });
            });
        });

        $(document).on('click', '#btn-conf-eliminar', function () {
            var url = $('#form-eliminar').attr('action');
            var data = $('#form-eliminar').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    $('#content-productos').load('{{ route('productos') }}?page={{ $page }}', function () {
                        $('#modalEliminar').modal('hide');
                        toastr.success('Producto Eliminado');
                    });
                } else {
                    $.each(result.errors, function (indexError, messages) {
                        $.each(messages, function (indexMessage, value) {
                            $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                        });
                    });
                }
            });
        });

        $(document).on('click', '#btn-ins-agregar', function () {
            $('.label-error').remove();
            $('#modalInsumoLabel').html('Agregar Insumo');
            $('#modalInsumos .modal-dialog').addClass('modal-sm');

            $('#form-insumo').attr('action', '{{ route('productos.insumos.agregar') }}');
            $('#insumo_id').val('').removeAttr('disabled');
            $('#cantidad').val('1');
            $('#insumo_producto_id').val('');

            $('#content-ins-table').addClass('hidden');
            $('#content-ins-form').removeClass('hidden');
            $('#content-ins-eliminar').addClass('hidden');
        });

        $(document).on('click', '.btn-ins-editar', function () {
            $('.label-error').remove();
            $('#modalInsumoLabel').html('Editar Insumo');
            $('#modalInsumos .modal-dialog').addClass('modal-sm');

            $('#form-insumo').attr('action', '{{ route('productos.insumos.editar') }}');
            $('#insumo_id').val($(this).attr('data-ins')).attr('disabled', true);
            $('#cantidad').val($(this).attr('data-cant')).focus().select();
            $('#insumo_producto_id').val($(this).attr('data-id'));

            $('#content-ins-table').addClass('hidden');
            $('#content-ins-form').removeClass('hidden');
            $('#content-ins-eliminar').addClass('hidden');

            $('#cantidad').focus().select();
        });

        $(document).on('click', '.btn-ins-quitar', function () {
            $('#delete_insumo_id').val($(this).attr('data-id'));

            $('#content-ins-table').addClass('hidden');
            $('#content-ins-form').addClass('hidden');
            $('#content-ins-eliminar').removeClass('hidden');

            $('#modalInsumos .modal-dialog').addClass('modal-sm');
        });

        $(document).on('click', '.btn-cerrar-ins', function () {
            $('#content-ins-table').removeClass('hidden');
            $('#content-ins-form').addClass('hidden');
            $('#content-ins-eliminar').addClass('hidden');

            $('#modalInsumos .modal-dialog').removeClass('modal-sm');
        });

        $(document).on('change', '#insumo_id', function () {
            $('#cantidad').focus().select();
        });

        $(document).on('click', '#btn-ins-guardar', function () {
            $('.label-error').remove();

            var url = $('#form-insumo').attr('action');
            var data = $('#form-insumo').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    var id = $('#insumo_producto_id').val();
                    var url = '{{ route('productos.insumos', ['id' => '%']) }}'
                    url = url.replace('%', $('#form-insumo').find('input[name=producto_id]').val());

                    $('#modalInsumos .modal-dialog').load(url, function () {
                        $('#modalInsumos .modal-dialog').removeClass('modal-sm');
                        toastr.success((id > 0) ? 'Insumo Editado' : 'Insumo Agregado');
                    });
                } else {
                    $.each(result.errors, function (indexError, messages) {
                        $.each(messages, function (indexMessage, value) {
                            $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                        });
                    });
                }
            }).fail(function (result) {
                var errors = JSON.parse(result.responseText).errors;

                $.each(errors, function (indexError, messages) {
                    $.each(messages, function (indexMessage, value) {
                        $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                    });
                });
            });
        });

        $(document).on('click', '#btn-ins-conf-quitar', function () {
            var url = $('#form-ins-quitar').attr('action');
            var data = $('#form-ins-quitar').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    var url = '{{ route('productos.insumos', ['id' => '%']) }}'
                    url = url.replace('%', $('#form-ins-quitar').find('input[name=producto_id]').val());

                    $('#modalInsumos .modal-dialog').load(url, function () {
                        $('#modalInsumos .modal-dialog').removeClass('modal-sm');
                        toastr.success('Insumo Quitado');
                    });
                } else {
                    $.each(result.errors, function (indexError, messages) {
                        $.each(messages, function (indexMessage, value) {
                            $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                        });
                    });
                }
            }).fail(function (result) {
                var errors = JSON.parse(result.responseText).errors;

                $.each(errors, function (indexError, messages) {
                    $.each(messages, function (indexMessage, value) {
                        $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                    });
                });
            });
        });
    </script>
@endsection
