@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1>Facturas Mensuales</h1>
@stop

@php
    $servicio = new \App\Services\FacturaService();
@endphp

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="GET" action="{{ route('facturas.facturacion-mensual') }}" class="mb-3 d-flex flex-wrap gap-2 align-items-center">

  <div class="d-flex align-items-center flex-wrap">

        <input type="text" name="cliente" id="cliente-buscador"
            value="{{ request('cliente') }}" placeholder="Buscar Cliente..."
            class="form-control w-auto mr-2 mb-2">

        <button type="submit" class="btn btn-secondary mr-2 mb-2">Filtrar</button>

    </div>

</form>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Importe</th>
            <th>Detalle</th>
            <th>Facturas Impagas</th>
            <th>Antiguedad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        
    @php
        $servicio = new \App\Services\FacturaService();
    @endphp

    @foreach ($facturas as $factura)
        @php
            $totalPagado = $factura->pagos->sum('monto');
            $impagas = $servicio->contarFacturasImpagas($factura);
            $antiguedad = $servicio->calcularAntiguedadRecurrente($factura);
        @endphp
        <tr>
            <td>{{ $factura->cliente->razon_social }}</td>
            <td>${{ number_format($factura->importe_original, 2, ',', '.') }}</td>
            <td>{{ $factura->detalle }}</td>
            <td>{{ $impagas }}</td>
            <td>{{ $antiguedad }} meses</td>
            <td>
                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-primary btn-sm">Ver factura</a>

                @can('crear-pagos')
                    @if ($totalPagado < $factura->importe_total && $factura->activo === 1)
                        <a href="{{ route('pagos.create.from.factura', $factura->id) }}" class="btn btn-success btn-sm">Pagar</a>
                    @endif
                @endcan
            </td>
        </tr>
    @endforeach

    </tbody>
</table>


<div class="pagination justify-content-end">
    {!! $facturas->links() !!}
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop