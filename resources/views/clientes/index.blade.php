@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')

    <h1>Listado de Clientes</h1>
@stop

@section('content')

    @can('crear-clientes')
        <a class="btn btn-success mb-3" href="{{ route('clientes.create') }}">Nuevo Cliente</a>
    @endcan

    <form method="GET" action="{{ route('clientes.index') }}" class="mb-3">
        <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar..." class="form-control w-25 d-inline-block">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>CUIT</th>
                <th>Razón Social</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>IVA</th>
                <th>Saldo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->cuit }}</td>
                <td>{{ $cliente->razon_social }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->condicion_iva }}</td>
                <td>
                    @if($cliente->tieneFacturasAdeudadas())
                        <a href="{{ route('facturas.index', ['cliente' => $cliente->razon_social, 'estado' => 'Pendiente']) }}" class="badge bg-warning">
                            Adeudado
                        </a>
                    @else
                        <span class="badge bg-success">Pagado</span>
                    @endif
                </td>
                <td>
                    @can('editar-clientes')
                        <a class="btn btn-info btn-sm" href="{{ route('clientes.edit', $cliente->id) }}">Editar</a>
                    @endcan
                    @can('borrar-clientes')
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    @endcan
                    @if ($cliente->tieneFacturasAdeudadas())
                     
                    @endif
                </td>
                
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pagination justify-content-end">
        {{ $clientes->links() }}
    </div>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop