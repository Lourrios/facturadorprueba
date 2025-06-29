@extends('adminlte::page')

@section('title', 'Pagina')

@section('content_header')
    <h1>Nueva pagina</h1>

@stop

@section('content')
   <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Lista de usuarios</h3>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Instancia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->getRoleNames()->first() }}</td>
                            <td>{{ $usuario->instancia->nombre ?? 'Sin instancia' }}</td>
                            <td class="text-center">
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($usuarios->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop