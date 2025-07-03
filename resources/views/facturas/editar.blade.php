@extends('adminlte::page')

@section('title', 'Editar Factura')

@section('content_header')
    <h1>Editar Factura</h1>
@stop

@section('content')
<form action="{{ route('facturas.update', $factura->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Cliente</label>
        <select name="cliente_id" class="form-control" required>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ $cliente->id == $factura->cliente_id ? 'selected' : '' }}>
                    {{ $cliente->razon_social }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Mes</label>
            <input type="text" name="periodo_mes" class="form-control" value="{{ $factura->periodo_mes }}" required>
        </div>
        <div class="form-group col-md-6">
            <label>Año</label>
            <input type="text" name="periodo_anio" class="form-control" value="{{ $factura->periodo_anio }}" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Desde</label>
            <input type="date" name="fecha_desde" class="form-control" value="{{ $factura->fecha_desde }}" required>
        </div>
        <div class="form-group col-md-6">
            <label>Hasta</label>
            <input type="date" name="fecha_hasta" class="form-control" value="{{ $factura->fecha_hasta }}" required>
        </div>
    </div>

    <div class="form-group">
        <label>Detalle del Servicio</label>
        <textarea name="detalle" class="form-control" required>{{ $factura->detalle }}</textarea>
    </div>

    <div class="form-group">
        <label>Importe Total</label>
        <input type="number" step="0.01" name="importe_total" class="form-control" value="{{ $factura->importe_total }}" required>
    </div>

    <div class="form-group">
        <label>Fecha de Emisión</label>
        <input type="date" name="fecha_emision" class="form-control" value="{{ $factura->fecha_emision }}" required>
    </div>

    <div class="form-group">
        <label>Condición de Pago</label>
        <select name="condicion_pago" class="form-control" required>
            <option value="">-- Seleccionar --</option>
            <option value="Contado" {{ $factura->condicion_pago == 'Contado' ? 'selected' : '' }}>Contado</option>
            <option value="Transferencia" {{ $factura->condicion_pago == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
            <option value="Cheque" {{ $factura->condicion_pago == 'Cheque' ? 'selected' : '' }}>Cheque</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop