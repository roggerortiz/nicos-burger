@extends('app')

@section('title', 'Movimientos')

@section('content')
    <div class="row">
        <div id="content-movimientos" class="col-md-10 col-md-offset-1">
            @include('movimientos.listado')
        </div>
    </div>

    <div class="modal fade" id="modalMovimiento" tabindex="-1" role="dialog" aria-labelledby="modalMovimientoLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalMovimientoLabel">Nuevo Movimiento</h4>
                </div>
                <div class="modal-body">
                    <form id="form-movimiento" action="">
                        @csrf
                        <input type="hidden" name="registro_id" value="{{ $registro->id }}">
                        <input type="hidden" name="movimiento_id" id="movimiento_id">
                        <div class="form-group">
                            <label>Tipo:</label>
                            <select id="tipo_mov" name="tipo_mov" class="form-control">
                                <option value="">- Seleccionar Tipo -</option>
                                <option value="venta">Venta</option>
                                <option value="compra">Compra</option>
                                <option value="gasto">Gasto</option>
                            </select>
                        </div>
                        <div class="form-group hidden" id="div-producto">
                            <label>Producto:</label>
                            <select id="producto_id" name="producto_id" class="form-control">
                                <option value="">- Seleccionar Producto -</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group hidden" id="div-insumo">
                            <label>Insumo:</label>
                            <select id="insumo_id" name="insumo_id" class="form-control">
                                <option value="">- Seleccionar Insumo -</option>
                                @foreach($insumos as $insumo)
                                    <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group hidden" id="div-cantidad">
                            <label>Cantidad:</label>
                            <input type="number" id="cantidad" min="1" name="cantidad" class="form-control" placeholder="Cantidad">
                        </div>
                        <div class="form-group hidden" id="div-descripcion">
                            <label>Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Descripción"></textarea>
                        </div>
                        <div class="form-group hidden" id="div-total">
                            <label>Monto:</label>
                            <input type="number" id="total" min="0.001" name="total" class="form-control" placeholder="Monto">
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
                    <h4 class="modal-title" id="modalEliminarLabel">Eliminar Movimiento</h4>
                </div>
                <div class="modal-body">
                    <p class="text-justify">¿Está seguro que desea eliminar esta movimiento?</p>
                    <form id="form-eliminar" action="{{ route('movimientos.eliminar') }}" class="hidden">
                        @csrf
                        <input type="hidden" name="movimiento_id" id="delete_movimiento_id">
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
        $(document).on('change', '#lista_mov', function () {
            $('#content-movimientos').load('{{ route('registros.movimientos', ['id' => $registro->id]) }}?tipo=' + $(this).val());
        });

        $(document).on('click', '.page-link', function () {
            event.preventDefault();
            $('#content-movimientos').load($(this).attr('href'));
        });

        $(document).on('shown.bs.modal', '#modalMovimiento', function () {
            $('.label-error').remove();

            if($('#tipo_mov').val() == 'venta') {
                if($('#movimiento_id').val() > 0) {
                    $('#cantidad').focus().select();
                } else {
                    $('#producto_id').focus();
                }
            } else if($('#tipo_mov').val() == 'compra') {
                if($('#movimiento_id').val() > 0) {
                    $('#cantidad').focus().select();
                } else {
                    $('#insumo_id').focus();
                }
            } else if($('#tipo_mov').val() == 'gasto') {
                $('#descripcion').focus().select();
            }
        });

        $(document).on('click', '#btn-nuevo', function () {
            $('.label-error').remove();
            $('#modalMovimientoLabel').html('Nuevo Movimiento');
            $('#form-movimiento').attr('action', 'crear');

            $('#div-producto').addClass('hidden');
            $('#div-insumo').addClass('hidden');
            $('#div-cantidad').addClass('hidden');
            $('#div-descripcion').addClass('hidden');
            $('#div-total').addClass('hidden');

            $('#tipo_mov').val('').removeAttr('disabled');

            $('#movimiento_id').val('');
            $('#producto_id').val('').removeAttr('disabled');
            $('#insumo_id').val('').removeAttr('disabled');
            $('#cantidad').val(1);
            $('#descripcion').val('');
            $('#total').val('');
        });

        $(document).on('click', '.btn-editar', function () {
            $('.label-error').remove();
            $('#modalMovimientoLabel').html('Editar Movimiento');
            $('#form-movimiento').attr('action', 'editar');

            var signo = $(this).attr('data-signo');
            var gasto = $(this).attr('data-gasto');

            $('#tipo_mov').attr('disabled', true);

            $('#producto_id').attr('disabled', true);
            $('#insumo_id').attr('disabled', true);

            if(signo == '1') {
                $('#div-producto').removeClass('hidden');
                $('#div-insumo').addClass('hidden');
                $('#div-cantidad').removeClass('hidden');
                $('#div-descripcion').addClass('hidden');
                $('#div-total').addClass('hidden');

                $('#tipo_mov').val('venta');

                $('#movimiento_id').val($(this).attr('data-id'));
                $('#producto_id').val($(this).attr('data-prod'));
                $('#insumo_id').val('');
                $('#cantidad').val($(this).attr('data-cant'));
                $('#descripcion').val('');
                $('#total').val('');
            } else {
                if(gasto == '1') {
                    $('#div-producto').addClass('hidden');
                    $('#div-insumo').addClass('hidden');
                    $('#div-cantidad').addClass('hidden');
                    $('#div-descripcion').removeClass('hidden');
                    $('#div-total').removeClass('hidden');

                    $('#tipo_mov').val('gasto');

                    $('#movimiento_id').val($(this).attr('data-id'));
                    $('#producto_id').val('');
                    $('#insumo_id').val('');
                    $('#cantidad').val('');
                    $('#descripcion').val($(this).attr('data-descrip'));
                    $('#total').val($(this).attr('data-total'));
                } else {
                    $('#div-producto').addClass('hidden');
                    $('#div-insumo').removeClass('hidden');
                    $('#div-cantidad').removeClass('hidden');
                    $('#div-descripcion').addClass('hidden');
                    $('#div-total').addClass('hidden');

                    $('#tipo_mov').val('compra');

                    $('#movimiento_id').val($(this).attr('data-id'));
                    $('#producto_id').val('');
                    $('#insumo_id').val($(this).attr('data-prod'));
                    $('#cantidad').val($(this).attr('data-cant'));
                    $('#descripcion').val('');
                    $('#total').val('');
                }
            }
        });

        $(document).on('click', '.btn-eliminar', function () {
            $('#delete_movimiento_id').val($(this).attr('data-id'));
        });

        $(document).on('change', '#tipo_mov', function () {
            $('#producto_id').val('');
            $('#insumo_id').val('');
            $('#cantidad').val('');
            $('#descripcion').val('');
            $('#total').val('');

            if($(this).val() == 'venta') {
                $('#div-producto').removeClass('hidden');
                $('#div-insumo').addClass('hidden');
                $('#div-cantidad').removeClass('hidden');
                $('#div-descripcion').addClass('hidden');
                $('#div-total').addClass('hidden');
                $('#producto_id').focus();
            } else if($(this).val() == 'compra') {
                $('#div-producto').addClass('hidden');
                $('#div-insumo').removeClass('hidden');
                $('#div-cantidad').removeClass('hidden');
                $('#div-descripcion').addClass('hidden');
                $('#div-total').removeClass('hidden');
                $('#insumo_id').focus();
            } else if($(this).val() == 'gasto') {
                $('#div-producto').addClass('hidden');
                $('#div-insumo').addClass('hidden');
                $('#div-cantidad').addClass('hidden');
                $('#div-descripcion').removeClass('hidden');
                $('#div-total').removeClass('hidden');
                $('#descripcion').focus();
            } else {
                $('#div-producto').addClass('hidden');
                $('#div-insumo').addClass('hidden');
                $('#div-cantidad').addClass('hidden');
                $('#div-descripcion').addClass('hidden');
                $('#div-total').addClass('hidden');
            }
        });

        $(document).on('change', '#producto_id', function () {
            $('#cantidad').focus().select();
        });

        $(document).on('change', '#insumo_id', function () {
            $('#cantidad').focus().select();
        });

        $(document).on('click', '#btn-guardar', function () {
            $('.label-error').remove();

            if($('#tipo_mov').val() == '') return false;

            var url = '';
            var data = $('#form-movimiento').serialize();

            if ($('#tipo_mov').val() == 'venta') {
                url = '{{ route('ventas.crear') }}';
            } else if ($('#tipo_mov').val() == 'compra') {
                url = '{{ route('compras.crear') }}';
            } else {
                url = '{{ route('gastos.crear') }}';
            }

            url = url.replace('crear', $('#form-movimiento').attr('action'));

            $.post(url, data, function (result) {
                if(result.success) {
                    $('#content-movimientos').load('{{ route('registros.movimientos', ['id' => $registro->id]) }}?page={{ $page }}&tipo=' + $("#tipo_mov").val());

                    if($('#movimiento_id').val() > 0) {
                        $('#modalMovimiento').modal('hide');
                    } else {
                        $('#movimiento_id').val('');
                        $('#producto_id').val('');
                        $('#insumo_id').val('');
                        $('#cantidad').val(1);
                        $('#descripcion').val('');
                        $('#total').val('');
                    }

                    toastr.success(($('#movimiento_id').val() > 0) ? 'Movimiento Editado' : 'Movimiento Registrado');
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
                    $('#content-movimientos').load('{{ route('registros.movimientos', ['id' => $registro->id]) }}?page={{ $page }}', function () {
                        $('#modalEliminar').modal('hide');
                        toastr.success('Movimiento Eliminado');
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
