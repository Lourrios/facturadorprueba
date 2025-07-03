@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1>Listado de Facturas</h1>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('facturas.create') }}" class="btn btn-primary mb-3">Nueva Factura</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Cliente</th>
            <th>Importe</th>
            <th>Periodo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturas as $factura)
        <tr>
            <td>{{ $factura->numero_factura }}</td>
            <td>{{ $factura->cliente->razon_social }}</td>
            <td>${{ number_format($factura->importe_total, 2, ',', '.') }}</td>
            <td>{{ $factura->fecha_desde }} - {{ $factura->fecha_hasta }}</td>
            <td>
                <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-info btn-sm">Editar</a>
                <a href="{{ asset('storage/factura_' . $factura->id . '.pdf') }}" target="_blank" class="btn btn-secondary btn-sm">PDF</a>
                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar factura?')">Borrar</button>
                </form>
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