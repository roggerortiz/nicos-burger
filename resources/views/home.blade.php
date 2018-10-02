@extends('app')

@section('title', 'Inicio')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Movimientos Diarios</h3>
                </div>
                <div class="box-body">
                    <div id="grafica-movimientos" class="content-grafica"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Productos Vendidos</h3>
                </div>
                <div class="box-body">
                    <div id="grafica-productos" class="content-grafica"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/highcharts.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.get('{{ route('graficas') }}', {}, function (result) {
                $.each(result.movimientos.ingresos, function (index, value) {
                    result.movimientos.ingresos[index] = Number(value);
                });

                $.each(result.movimientos.egresos, function (index, value) {
                    result.movimientos.egresos[index] = Number(value);
                });

                $.each(result.productos, function (index, producto) {
                    result.productos[index].y = Number(producto.y);
                });

                console.log(result);

                Highcharts.chart('grafica-movimientos', {
                    chart: {
                        type: 'column'
                    },
                    credits: false,
                    exporting: {
                        enabled: false
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: result.movimientos.categorias,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total (S/)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<strong style="font-size:12px">{point.key}</strong><hr style="margin: 2px 0; border-color: #000"><table>',
                        pointFormat: '<tr><td style="font-size: 11px; padding:0;"><b>{series.name}:</b>&nbsp;&nbsp;</td>' +
                        '<td style="font-size: 11px; padding:0;">S/ {point.y:.1f}</td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Ingresos',
                        color: 'rgb(54,167,54)',
                        data: result.movimientos.ingresos

                    }, {
                        name: 'Egresos',
                        color: 'rgb(234,18,11)',
                        data: result.movimientos.categorias

                    }]
                });

                Highcharts.chart('grafica-productos', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    credits: false,
                    exporting: {
                        enabled: false
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        headerFormat: '<strong style="font-size:11px">{point.key}: </strong> {point.percentage:.2f} %',
                        pointFormat: '',
                        footerFormat: '',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}:</b> {point.y} ({point.percentage:.1f} %)',
                                distance: -50,
                                filter: {
                                    property: 'percentage',
                                    operator: '>',
                                    value: 4
                                }
                            },
                            showInLegend: false
                        }
                    },
                    series: [{
                        name: 'Ventas',
                        colorByPoint: true,
                        data: result.productos,
                    }]
                });
            });
        });
    </script>
@endsection
