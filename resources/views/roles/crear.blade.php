@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Roles</h1>
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

            
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Nombre del Rol -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name">Nombre del Rol:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>

                    <!-- Permisos para este Rol -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="permission">Permisos para este Rol:</label>
                            <br/>
                            @foreach($permission as $value)
                                <div class="form-check">
                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="form-check-input" id="permiso_{{ $value->id }}">
                                    <label class="form-check-label" for="permiso_{{ $value->id }}">{{ $value->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>        
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>




@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop