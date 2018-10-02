@extends('app')

@section('title', 'Insumos')

@section('content')
    <div class="row">
        <div id="content-insumos" class="col-md-6 col-md-offset-3">
            @include('insumos.listado')
        </div>
    </div>

    <div class="modal fade" id="modalInsumo" tabindex="-1" role="dialog" aria-labelledby="modalInsumoLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalInsumoLabel">Nuevo Insumo</h4>
                </div>
                <div class="modal-body">
                    <form id="form-insumo" action="">
                        @csrf
                        <input type="hidden" name="insumo_id" id="insumo_id">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label>Precio:</label>
                            <input type="number" id="precio" name="precio" min="0.0001" class="form-control" placeholder="Precio">
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
                    <h4 class="modal-title" id="modalEliminarLabel">Eliminar Insumo</h4>
                </div>
                <div class="modal-body">
                    <p class="text-justify">¿Está seguro que desea eliminar este insumo?</p>
                    <form id="form-eliminar" action="{{ route('insumos.eliminar') }}" class="hidden">
                        @csrf
                        <input type="hidden" name="insumo_id" id="delete_insumo_id">
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
            $('#content-insumos').load($(this).attr('href'));
        });

        $(document).on('shown.bs.modal', '#modalInsumo', function () {
            $('.label-error').remove();
            $('#nombre').focus().select();
        });

        $(document).on('click', '#btn-nuevo', function () {
            $('.label-error').remove();
            $('#modalInsumoLabel').html('Nuevo Insumo');
            $('#form-insumo').attr('action', '{{ route('insumos.crear') }}');
            $('#insumo_id').val('');
            $('#nombre').val('');
        });

        $(document).on('click', '.btn-editar', function () {
            $('.label-error').remove();
            $('#modalInsumoLabel').html('Editar Insumo');
            $('#form-insumo').attr('action', '{{ route('insumos.editar') }}');
            $('#insumo_id').val($(this).attr('data-id'));
            $('#nombre').val($(this).attr('data-nomb'));
            $('#precio').val($(this).attr('data-precio'));
        });

        $(document).on('click', '.btn-eliminar', function () {
            $('#delete_insumo_id').val($(this).attr('data-id'));
        });

        $(document).on('click', '#btn-guardar', function () {
            $('.label-error').remove();

            var url = $('#form-insumo').attr('action');
            var data = $('#form-insumo').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    $('#content-insumos').load('{{ route('insumos') }}?page={{ $page }}', function () {
                        $('#modalInsumo').modal('hide');
                        toastr.success(($('#insumo_id').val() > 0) ? 'Insumo Actualizado' : 'Insumo Registrado');
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
                    $('#content-insumos').load('{{ route('insumos') }}?page={{ $page }}', function () {
                        $('#modalEliminar').modal('hide');
                        toastr.success('Insumo Eliminado');
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
    </script>
@endsection
