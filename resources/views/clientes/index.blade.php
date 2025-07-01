@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    @can('ver-clientes')
        <p>Contenido</p>
        <h3 class="text-center">Contenido</h3>

        @can('crear-clientes')
            <a class="btn btn-warning" href="{{ route('clientes.create') }}">Nuevo</a>
        @endcan

        <form method="GET" action="{{ route('clientes.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar clientes..." value="{{ request('buscar') }}" autofocus>
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>

        <table class="table table-striped mt-2">
            <thead style="background-color:#6777ef">  
                <th style="display: none;">ID</th>                                   
                <th style="color:#fff;">Razon Social</th>
                <th style="color:#fff;">Cuil</th>
                <th style="color:#fff;">Condicion IVA</th>
                <th style="color:#fff;">E-mail</th>
                <th style="color:#fff;">Telefono</th>
                <th style="color:#fff;">Direccion</th>   
                <th style="color:#fff;">Acciones</th>                                                                   
            </thead>
            <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td style="display: none;">{{ $cliente->id }}</td>
                    <td>{{ $cliente->razon_social }}</td>
                    <td>{{ $cliente->cuil }}</td>
                    <td>{{ $cliente->condicion_iva }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>
                        @can('editar-clientes')
                            <a class="btn btn-info" href="{{ route('clientes.edit', $cliente->id) }}">Editar</a>
                        @endcan

                        @can('borrar-clientes')
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro que deseas borrar este cliente?')">
                                    Borrar
                                </button>
                            </form>
                        @endcan
                    
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Centramos la paginación a la derecha -->
        <div class="pagination justify-content-end">
            {{ $clientes->appends(['buscar' => request('buscar')])->links() }}
        </div>
    @endcan
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop