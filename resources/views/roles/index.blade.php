@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
         @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif



          @can('crear-rol')
            <a class="btn btn-warning" href="{{ route('roles.create') }}">Nuevo</a>                        
     

        @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


          <table class="table table-striped mt-2">
    <thead style="background-color:#6777ef">                                                       
        <tr>
            <th style="color:#fff;">Rol</th>
            <th style="color:#fff;">Acciones</th>
        </tr>
    </thead>  
    <tbody>
    @foreach ($roles as $role)
    <tr>                           
        <td>{{ $role->name }}</td>
        <td>                                
            @can('editar-rol')
                <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Editar</a>
            @endcan
            
            @can('borrar-rol')
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro que deseas borrar este rol?')">Borrar</button>
                </form>
            @endcan
        </td>
    </tr>
    @endforeach
    </tbody>               
</table>
     @endcan
<!-- Centramos la paginación a la derecha -->
<div class="pagination justify-content-end">
    {!! $roles->links() !!} 
</div>



@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop