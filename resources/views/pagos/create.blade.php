@extends('adminlte::page')


@section('title', 'Nuevo Pago')

@section('content_header')
    <h1>Registrar Pago</h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>¡Atención!</strong> Por favor, corregí los siguientes errores:<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pagos.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Monto abonado *</label>
        <input type="number" name="monto" class="form-control" value="{{ old('monto') }}" min="1" required>
    </div>

    <div class="form-group">
        <label>Método de pago *</label>
        <select name="metodo_pago" class="form-control" required>
            <option value="">-- Seleccionar --</option>
            <option value="Efectivo" {{ (old('condicion_pago', $factura->condicion_pago ?? '') == 'Efectivo') ? 'selected' : '' }}>Efectivo</option>
            <option value="Transferencia" {{ (old('condicion_pago', $factura->condicion_pago ?? '') == 'Transferencia') ? 'selected' : '' }}>Transferencia</option>
            <option value="Cheque" {{ (old('condicion_pago', $factura->condicion_pago ?? '') == 'Cheque') ? 'selected' : '' }}>Cheque</option>
            <option value="Tarjeta" {{ (old('condicion_pago', $factura->condicion_pago ?? '') == 'Tarjeta') ? 'selected' : '' }}>Tarjeta</option>
        </select>
    </div>


    <div class="form-group">
        <label>Observaciones</label>
        <input type="text" name="observaciones" class="form-control" value="{{ old('observaciones') }}">
    </div>
    
    <div class="form-group">
        <label>Numero de factura *</label>
        <input type="text" name="numero_factura" class="form-control" value="{{ $factura->numero_factura ?? '' }}" placeholder="Ej: A000001." required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop