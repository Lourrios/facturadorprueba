@extends('adminlte::page')

@section('title', 'Notas')

@section('content_header')
    <h1>Notas generadas</h1>
@stop

@section('content')
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Factura</th>
            <th>Tipo</th>
            <th>Motivo</th>
            <th>Importe</th>
            <th>Fecha</th>
            <th>Acciones</th> {{-- Nueva columna --}}
        </tr>
    </thead>
    <tbody>
        @foreach($notas as $nota)
            <tr>
                <td>{{ $nota->factura->numero_factura }}</td>
                <td>{{ ucfirst($nota->tipo) }}</td>
                <td>{{ $nota->motivo }}</td>
                <td>${{ number_format($nota->importe, 2, ',', '.') }}</td>
                <td>{{ $nota->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('notas.show', $nota->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('notas.pdf', $nota->id) }}" class="btn btn-sm btn-dark" target="_blank">PDF</a>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop