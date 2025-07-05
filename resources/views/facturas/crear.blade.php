@extends('adminlte::page')

@section('title', 'Nueva Factura')

@section('content_header')
    <h1>Registrar Factura</h1>
@stop

@section('content')
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

<form action="{{route('facturas.store')}}" method= "POST">
                @csrf
                <div class="form-group">
                    <label>Cliente</label>
                    <select name="cliente_id" class="form-control" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->razon_social}}</option>
                        @endforeach
                    </select>
                </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Desde</label>
                    <input type="datetime-local" name="fecha_desde" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Hasta</label>
                    <input type="datetime-local" name="fecha_hasta" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Detalle del Servicio</label>
                <textarea name="detalle" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Importe Total</label>
                <input type="number" name="importe_total" step="0.01" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Condición de Pago</label>
                <select name="condicion_pago" class="form-control" required>
                    <option value="">-- Seleccionar --</option>
                    <option value="Contado">Contado</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Cheque">Cheque</option>
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