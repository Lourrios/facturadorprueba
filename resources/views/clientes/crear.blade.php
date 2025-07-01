@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Alta de clientes</h1>
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


    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Razon social -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">Razon Social</label>
                    <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social') }}">
                </div>
            </div>

            <!-- Cuil -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="cuil">Cuil</label>
                    <input type="text" name="cuil" class="form-control" value="{{ old('cuil') }}">
                </div>
            </div>

            <!-- Dirección -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                </div>
            </div>

            <!-- Email -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>

            <!-- Teléfono -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                </div>
            </div>

            <!-- Condición IVA -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="condicion_iva">Condición IVA</label>
                    <select name="condicion_iva" class="form-control">
                        <option value="">-- Seleccione una opción --</option>
                        <option value="Responsable Inscripto" {{ old('condicion_iva') == 'Responsable Inscripto' ? 'selected' : '' }}>Responsable Inscripto</option>
                        <option value="Monotributista" {{ old('condicion_iva') == 'Monotributista' ? 'selected' : '' }}>Monotributista</option>
                        <option value="Exento" {{ old('condicion_iva') == 'Exento' ? 'selected' : '' }}>Exento</option>
                        <option value="Consumidor Final" {{ old('condicion_iva') == 'Consumidor Final' ? 'selected' : '' }}>Consumidor Final</option>
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