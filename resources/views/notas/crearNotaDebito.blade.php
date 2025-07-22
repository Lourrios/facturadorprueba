@extends('adminlte::page')

@section('title', 'Nota de Crédito')

@section('content_header')
    <h1>Generar Nota de Crédito</h1>
@stop

@section('content')
<div class="card p-4 shadow w-75 mx-auto">
    <form action="{{ route('notas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="factura_id" value="{{ $factura->id }}">
        <input type="hidden" name="tipo" value="credito">

        {{-- Encabezado estilo AFIP --}}
        <div class="text-center mb-4">
          <h4><strong>NOTA DE DÉBITO A</strong></h4>
            <input type="hidden" name="tipo" value="debito">
            <p><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Razón Social:</strong> {{ $factura->cliente->razon_social }}</p>
                <p><strong>Domicilio:</strong> {{ $factura->cliente->direccion ?? '-' }}</p>
                <p><strong>CUIT:</strong> {{ $factura->cliente->cuit }}</p>
                <p><strong>IVA:</strong> {{ $factura->cliente->condicion_iva }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Condición de venta:</strong> {{ $factura->condicion_pago }}</p>
                <p><strong>Factura asociada:</strong> {{ $factura->numero_factura }}</p>
            </div>
        </div>

        <hr>

        {{-- Detalle Nota --}}
        <div class="mb-3">
            <label><strong>Motivo:</strong></label>
            <input type="text" name="motivo" class="form-control" required>
        </div>

        <div class="mb-3 row">
            <div class="col-md-4">
                <label><strong>Importe:</strong></label>
                <input type="number" step="0.01" name="importe" class="form-control" value="{{ $factura->importe_total }}" required>
            </div>
        </div>

        {{-- Botones --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-success">Guardar Nota</button>
            <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
<x-boton-volver />
@stop

@section('css')

    {{-- Add here extra stylesheets --}}
   <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop