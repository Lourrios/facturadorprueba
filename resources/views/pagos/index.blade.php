@extends('adminlte::page')

@section('title', 'pagos')

@section('content_header')

    <h1>Listado de Pagos</h1>
@stop

@section('content')

    @can('crear-pagos')
        <a class="btn btn-success mb-3" href="{{ route('pagos.create') }}">Nuevo Pago</a>
    @endcan

    <form method="GET" action="{{ route('pagos.index') }}" class="mb-3">
        <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar..." class="form-control w-25 d-inline-block">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Factura</th>
                <th>Fecha de pago</th>
                <th>Metodo de pago</th>
                <th>Monto</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pagos as $pago)
            <tr>
               <td> {{ $pago->factura ? $pago->factura->numero_factura : 'Factura no encontrada' }}</td>
                <td>{{ $pago->fecha_pago }}</td>
                <td>{{ $pago->metodo_pago }}</td>
                <td>${{ $pago->monto }}</td>
                <td title="{{ $pago->observaciones }}">
                    {{ \Illuminate\Support\Str::limit($pago->observaciones, 30, '...') ?? 'No hay observaciones' }}
                </td>

                <td>
                    @can('editar-pagos')
                        <a class="btn btn-info btn-sm" href="{{ route('pagos.edit', $pago->id) }}">Editar</a>
                    @endcan
                    @can('borrar-pagos')
                        <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pagination justify-content-end">
        {{ $pagos->links() }}
    </div>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop