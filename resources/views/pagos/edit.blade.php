@extends('adminlte::page')

@section('title', 'Editar Pago')

@section('content_header')
    <h1>Editar Pago</h1>
@stop

@section('content')

         @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Atención!</strong> Corregí los siguientes errores:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('pagos.update', $pago->id)}}" method="POST"> 
    @csrf
    @method('PUT')

    <div class="form-group">
            <label>Número de Factura</label>
            <input type="text" class="form-control" value="{{ $pago->factura->numero_factura ?? 'No disponible' }}" readonly>
        </div>

        <div class="form-group">
            <label>Monto abonado *</label>
            <input type="number" name="monto" class="form-control" value="{{ old('monto', $pago->monto) }}" min="1" required>
        </div>

        <div class="form-group">
            <label>Método de pago *</label>
            <select name="metodo_pago" class="form-control" required>
                @foreach(['Efectivo', 'Transferencia', 'Cheque', 'Tarjeta'] as $metodo)
                    <option value="{{ $metodo }}" {{ $pago->metodo_pago == $metodo ? 'selected' : '' }}>
                        {{ $metodo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Observaciones</label>
            <input type="text" name="observaciones" class="form-control" value="{{ old('observaciones', $pago->observaciones) }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
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