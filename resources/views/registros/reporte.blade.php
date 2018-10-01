<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reporte {{ $registro->fecha }} - Nico's Burgers </title>
    <link rel="stylesheet" href="{{ asset('dist/css/pdf.css') }}" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ asset('dist/img/logo3.png') }}">
        <h1>Reporte {{ $registro->fecha }}</h1>
    </div>
    <div id="project">
        <strong>VENTAS</strong>
    </div>
</header>

<main>
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Producto</th>
                <th class="number">Cantidad</th>
                <th class="money">Precio</th>
                <th class="money">Total</th>
            </tr>
        </thead>
        <tbody>
        @if($categorias->count() > 0)
            @foreach($categorias as $categoria)
                @foreach($categoria->ventas as $venta)
                    <tr>
                        @if($categoria->ventas->first()->id == $venta->id)
                            <td rowspan="{{ $categoria->ventas->count() }}">
                                <b>{{ strtoupper($categoria->nombre) }}</b>
                            </td>
                        @endif
                        <td>{{ $venta->producto }}</td>
                        <td class="number">{{ $venta->cantidad }}</td>
                        <td class="money">{{ $venta->precio }}</td>
                        <td class="money">{{ $venta->total }}</td>
                    </tr>
                @endforeach
            @endforeach
        @else
            <tr>
                <td colspan="5">No se encontraron categorías registradas.</td>
            </tr>
        @endif
        </tbody>
    </table>
</main>

<header class="clearfix">
    <div id="project">
        <strong>GASTOS</strong>
    </div>
</header>

<main>
    <table class="table-middle">
        <thead>
        <tr>
            <th>Descripción</th>
            <th class="money">Monto</th>
        </tr>
        </thead>
        <tbody>
        @if($gastos->count() > 0)
            @foreach($gastos as $gasto)
                <tr>
                    <td class="text-left">{{ $gasto->descripcion }}</td>
                    <td class="money">{{ $gasto->monto }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2">No se encontraron gastos registrados.</td>
            </tr>
        @endif
        </tbody>
    </table>
</main>

<header class="clearfix">
    <div id="project">
        <strong>RESUMEN</strong>
    </div>
</header>

<main>
    <table class="table-middle">
        <thead>
        <tr>
            <th>VENTAS</th>
            <th>GASTOS</th>
            <th>{{ ($registro->ganancia > 0) ? 'GANANCIA' : 'PÉRDIDA' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="money"><b>S/ {{ $registro->ventas }}</b></td>
            <td class="money"><b>S/ {{ $registro->gastos }}</b></td>
            <td class="money"><b>S/ {{ $registro->ganancia }}</b></td>
        </tr>
        </tbody>
    </table>
</main>

<br><br>

<header class="clearfix">
    <div id="project"></div>
    <div id="project">
        <strong>INSUMOS CONSUMIDOS</strong>
    </div>
</header>

<main>
    <table class="table-middle">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Cantidad</th>
        </tr>
        </thead>
        <tbody>
        @if($insumos->count() > 0)
            @foreach($insumos as $insumo)
                <tr>
                    <td>{{ $insumo->nombre }}</td>
                    <td class="number">{{ $insumo->cantidad }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2">No se encontraron insumos.</td>
            </tr>
        @endif
        </tbody>
    </table>
</main>

</body>
</html>
