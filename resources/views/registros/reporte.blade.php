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
        <img src="{{ asset('dist/img/logo2.png') }}">
        <h1>Informe - {{ $registro->dia }} {{ $registro->fecha }}</h1>
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
                <th class="money">Precio Unit.</th>
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
                                {{ $categoria->nombre }}
                            </td>
                        @endif
                        <td>{{ $venta->descripcion }}</td>
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
    <div id="project"></div>
    <div id="project">
        <strong>INSUMOS CONSUMIDOS</strong>
    </div>
</header>

<main class="">
    <table class="w-60">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Cant. Inicial</th>
            <th>Cant. Consumida</th>
            <th>Cant. Final</th>
        </tr>
        </thead>
        <tbody>
        @if($insumos->count() > 0)
            @foreach($insumos as $insumo)
                <tr>
                    <td>{{ $insumo->nombre }}</td>
                    <td class="number">{{ $insumo->cantidad_inicial }}</td>
                    <td class="number">{{ $insumo->cantidad_consumida }}</td>
                    <td class="number">{{ $insumo->cantidad_final }}</td>
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

<header class="clearfix">
    <div id="project">
        <strong>GASTOS</strong>
    </div>
</header>

<main>
    <table class="w-50">
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
                    <td class="money">{{ $gasto->total }}</td>
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
    <table class="w-50">
        <thead>
        <tr>
            <th>INGRESOS</th>
            <th>EGRESOS</th>
            <th>{{ ($registro->total > 0) ? 'GANANCIA' : 'PÉRDIDA' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="money">S/ {{ $registro->ingresos }}</td>
            <td class="money">S/ {{ $registro->egresos }}</td>
            <td class="money">S/ {{ $registro->total }}</td>
        </tr>
        </tbody>
    </table>
</main>

<div class="page-break">
    <header class="clearfix">
        <div id="project">
            <strong>COMPRAS</strong>
        </div>
    </header>

    <main>
        <table class="w-80">
            <thead>
            <tr>
                <th>Insumo</th>
                <th class="number">Cantidad</th>
                <th class="money">Precio Unit.</th>
                <th class="money">Total</th>
            </tr>
            </thead>
            <tbody>
            @if($compras->count() > 0)
                @foreach($compras as $compra)
                    <tr>
                        <td>{{ $compra->descripcion }}</td>
                        <td class="number">{{ $compra->cantidad }}</td>
                        <td class="money">{{ $compra->precio }}</td>
                        <td class="money">{{ $compra->total }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No se encontraron compras registradas.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
