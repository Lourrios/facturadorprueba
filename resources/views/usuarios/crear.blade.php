@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Alta de usuarios</h1>
@stop

@section('content')
    
            @if ($errors->any())                                                
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>                        
                                @foreach ($errors->all() as $error)                                    
                                    <span class="badge badge-danger">{{ $error }}</span>
                                @endforeach                        
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
            @endif


           <form action="{{ route('usuarios.store') }}" method="POST">
    @csrf

    <div class="row">
        <!-- Nombre -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
        </div>

        <!-- Email -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
        </div>

        <!-- Password -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        <!-- Confirmar Password -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="confirm-password">Confirmar Password</label>
                <input type="password" name="confirm-password" class="form-control">
            </div>
        </div>

        <!-- Roles -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="roles">Roles</label>
                <select name="roles[]" class="form-control">
                    @foreach($roles as $id => $rol)
                        <option value="{{ $id }}">{{ $rol }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>




@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop