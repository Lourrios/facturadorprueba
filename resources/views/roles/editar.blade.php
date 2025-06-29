@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Roles</h1>
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


            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <!-- Nombre del Rol -->
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre del Rol:</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}">
                                </div>
                            </div>

                            <!-- Permisos para este Rol -->
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="permission">Permisos para este Rol:</label>
                                    <br/>
                                    @foreach($permission as $permiso)
                                        <div class="form-check">
                                            <input type="checkbox"
                                                name="permission[]"
                                                value="{{ $permiso->id }}"
                                                class="form-check-input"
                                                id="permiso_{{ $permiso->id }}"
                                                {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permiso_{{ $permiso->id }}">
                                                {{ $permiso->name }}
                                            </label>
                                        </div>
                                    @endforeach
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