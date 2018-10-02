@extends('app')

@section('title', 'Registros')

@section('content')
    <div class="row">
        <div id="content-registros" class="col-md-10 col-md-offset-1">
            @include('registros.listado')
        </div>
    </div>

    <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="modalRegistroLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalRegistroLabel">Nuevo Registro</h4>
                </div>
                <div class="modal-body">
                    <form id="form-registro" action="{{ route('registros.crear') }}">
                        @csrf
                        <div class="form-group">
                            <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" value="{{ date('Y-m-d') }}">
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
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.page-link', function () {
            event.preventDefault();
            $('#content-registros').load($(this).attr('href'));
        });

        $(document).on('shown.bs.modal', '#modalRegistro', function () {
            $('.label-error').remove();
            $('#fecha').focus().select();
        });

        $(document).on('click', '#btn-guardar', function () {
            $('.label-error').remove();
            var url = $('#form-registro').attr('action');
            var data = $('#form-registro').serialize();

            $.post(url, data, function (result) {
                if(result.success) {
                    $('#content-registros').load('{{ route('registros') }}?page={{ $page }}', function () {
                        $("#modalRegistro").modal('hide');
                        toastr.success('Registro Exitoso');
                    });
                } else {
                    $("#fecha").parent().append($('<label id="fecha-error" class="label-error text-red">').html(result.message));
                }
            });
        });
    </script>
@endsection
