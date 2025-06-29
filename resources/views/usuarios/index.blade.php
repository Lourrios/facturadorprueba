@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    @can('ver-usuarios')
    <p>Contenido</p>
    <h3 class="text-center">Contenido</h3>

    @can('crear-usuarios')
        <a class="btn btn-warning" href="{{ route('usuarios.create') }}">Nuevo</a>
    @endcan

    <table class="table table-striped mt-2">
        <thead style="background-color:#6777ef">                                     
            <th style="display: none;">ID</th>
            <th style="color:#fff;">Nombre</th>
            <th style="color:#fff;">E-mail</th>
            <th style="color:#fff;">Rol</th>
            <th style="color:#fff;">Acciones</th>                                                                   
        </thead>
        <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td style="display: none;">{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    @if(!empty($usuario->getRoleNames()))
                        @foreach($usuario->getRoleNames() as $rolNombre)                                       
                            <h5><span class="badge badge-dark">{{ $rolNombre }}</span></h5>
                        @endforeach
                    @endif
                </td>

                <td>
                    @can('editar-usuarios')
                        <a class="btn btn-info" href="{{ route('usuarios.edit', $usuario->id) }}">Editar</a>
                    @endcan

                    @can('borrar-usuarios')
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro que deseas borrar este usuario?')">
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
        {!! $usuarios->links() !!}
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