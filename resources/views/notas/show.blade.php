@extends('adminlte::page')

@section('title', 'Detalle de Nota')

@section('content_header')
    <h1>Detalle Nota de {{ ucfirst($nota->tipo) }} N° {{ $nota->id }}</h1>
@stop

@section('content')
<div class="card p-4 shadow w-75 mx-auto">
    <div class="text-center mb-4">
        <h4><strong>NOTA DE {{ strtoupper($nota->tipo) }} A</strong></h4>
        <p><strong>N°:</strong> {{ $nota->id }}</p>
        <p><strong>Fecha:</strong> {{ $nota->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <p><strong>Razón Social:</strong> {{ $nota->factura->cliente->razon_social }}</p>
            <p><strong>Domicilio:</strong> {{ $nota->factura->cliente->direccion ?? '-' }}</p>
            <p><strong>CUIT:</strong> {{ $nota->factura->cliente->cuit }}</p>
            <p><strong>IVA:</strong> {{ $nota->factura->cliente->condicion_iva }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Condición de venta:</strong> {{ $nota->factura->condicion_pago }}</p>
            <p><strong>Factura asociada:</strong> {{ $nota->factura->numero_factura }}</p>
        </div>
    </div>

    <hr>

    <div class="mb-3">
        <p><strong>Motivo:</strong> {{ $nota->motivo }}</p>
        <p><strong>Importe:</strong> ${{ number_format($nota->importe, 2, ',', '.') }}</p>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('notas.index') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('notas.pdf', $nota->id) }}" target="_blank" class="btn btn-primary">Descargar PDF</a>
    </div>
</div>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop