@extends('adminlte::page')


@section('title', 'Editar Cliente')


@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <strong>¡Atención!</strong> Por favor, corregí los siguientes errores:<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>CUIT / CUIL *</label>
        <input type="text" name="cuit" class="form-control" value="{{ old('cuit', $cliente->cuit) }}" required>
    </div>

    <div class="form-group">
        <label>Razón Social *</label>
        <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social', $cliente->razon_social) }}" required>
    </div>

    <div class="form-group">
        <label>Dirección *</label>
        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}" required>
    </div>

    <div class="form-group">
        <label>Email de contacto *</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}">
    </div>

    <div class="form-group">
        <label>Condición frente al IVA *</label>
        <select name="condicion_iva" class="form-control" required>
            <option value="Responsable Inscripto" {{ $cliente->condicion_iva == 'Responsable Inscripto' ? 'selected' : '' }}>Responsable Inscripto</option>
            <option value="Monotributo" {{ $cliente->condicion_iva == 'Monotributo' ? 'selected' : '' }}>Monotributo</option>
            <option value="Exento" {{ $cliente->condicion_iva == 'Exento' ? 'selected' : '' }}>Exento</option>
            <option value="Consumidor Final" {{ $cliente->condicion_iva == 'Consumidor Final' ? 'selected' : '' }}>Consumidor Final</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop