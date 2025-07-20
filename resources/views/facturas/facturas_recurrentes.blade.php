@extends('adminlte::page')

@section('title', 'Facturas del ciclo')

@section('content_header')
    <h1>Facturas del Ciclo</h1>
@stop

@section('content')
    <a href="{{ route('facturas.facturacion-mensual') }}" class="btn btn-secondary mb-3">Volver</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha Emisión</th>
                <th>Importe</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $factura)
                @php
                    $pagado = $factura->pagos->sum('monto');
                    $estado = $pagado >= $factura->importe_total ? 'Pagada' : 'Impaga';
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</td>
                    <td>${{ number_format($factura->importe_total, 2, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $estado == 'Pagada' ? 'badge-success' : 'badge-danger' }}">
                            {{ $estado }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-sm btn-primary">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
