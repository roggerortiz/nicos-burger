@extends('app')

@section('title', 'Ventas')

@section('content')
    <div class="row">
        <div id="content-ventas" class="col-md-10 col-md-offset-1">
            @include('ventas.index')
        </div>
    </div>

    <div class="modal fade" id="modalVenta" tabindex="-1" role="dialog" aria-labelledby="modalVentaLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalVentaLabel">Nueva Venta</h4>
                </div>
                <div class="modal-body">
                    <form id="form-venta" action="">
                        @csrf
                        <input type="hidden" name="registro_id" value="{{ $registro->id }}">
                        <input type="hidden" name="venta_id" id="venta_id">
                        <div class="form-group">
                            <label>Producto:</label>
                            <select id="producto_id" name="producto_id" class="form-control">
                                <option value="">- Seleccionar Producto -</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input type="number" id="cantidad" min="1" name="cantidad" class="form-control" placeholder="Cantidad">
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
                    <h4 class="modal-title" id="modalEliminarLabel">Eliminar Venta</h4>
                </div>
                <div class="modal-body">
                    <p class="text-justify">¿Está seguro que desea eliminar esta venta?</p>
                    <form id="form-eliminar" action="{{ route('ventas.eliminar') }}" class="hidden">
                        @csrf
                        <input type="hidden" name="venta_id" id="delete_venta_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" id="btn-conf-eliminar" class="btn btn-danger">Si</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.page-link', function () {
            event.preventDefault();
            $('#content-ventas').load($(this).attr('href'));
        });

        $(document).on('shown.bs.modal', '#modalVenta', function () {
            $('.label-error').remove();

            if($('#producto_id').hasClass('hidden')) {
                $('#cantidad').focus().select();
            } else {
                $('#producto_id').focus();
            }
        });

        $(document).on('click', '#btn-nuevo', function () {
            $('.label-error').remove();
            $('#modalVentaLabel').html('Nueva Venta');
            $('#form-venta').attr('action', '{{ route('ventas.crear') }}');
            $('#venta_id').val('');
            $('#producto_id').val('').removeAttr('disabled');
            $('#cantidad').val(1);
        });

        $(document).on('click', '.btn-editar', function () {
            $('.label-error').remove();
            $('#modalVentaLabel').html('Editar Venta');
            $('#form-venta').attr('action', '{{ route('ventas.editar') }}');
            $('#venta_id').val($(this).attr('data-id'));
            $('#producto_id').val('').attr('disabled', true);
            $('#cantidad').val($(this).attr('data-cant'));
        });

        $(document).on('click', '.btn-eliminar', function () {
            $('#delete_venta_id').val($(this).attr('data-id'));
        });

        $(document).on('change', '#producto_id', function () {
            $('#cantidad').focus().select();
        });

        $(document).on('click', '#btn-guardar', function () {
            $('.label-error').remove();

            var url = $('#form-venta').attr('action');
            var data = $('#form-venta').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    $('#content-ventas').load('{{ route('registros.ventas', ['id' => $registro->id]) }}?page={{ $page }}');

                    if($('#venta_id').val() > 0) {
                        $('#modalVenta').modal('hide');
                    } else {
                        $('#producto_id').val('').focus();
                        $('#cantidad').val(1);
                    }

                    toastr.success(($('#venta_id').val() > 0) ? 'Venta Actualizada' : 'Venta Registrada');
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
                    $('#content-ventas').load('{{ route('registros.ventas', ['id' => $registro->id]) }}?page={{ $page }}');
                    $('#modalEliminar').modal('hide');
                    toastr.success('Venta Eliminada');
                } else {
                    $.each(result.errors, function (indexError, messages) {
                        $.each(messages, function (indexMessage, value) {
                            $('#'+indexError).parent().append($('<label class="label-error text-red">').html(value));
                        });
                    });
                }
            });
        });
    </script>
@endsection
