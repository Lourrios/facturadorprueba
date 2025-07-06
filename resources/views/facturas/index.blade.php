@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1>Listado de Facturas</h1>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('facturas.create') }}" class="btn btn-primary mb-3">Nueva Factura</a>

<form method="GET" action="{{ route('facturas.index') }}" class="mb-3 d-flex flex-wrap gap-2 align-items-center">
<input type="text" name="cliente" id="cliente-buscador" value="{{ request('cliente') }}" placeholder="Buscar Cliente..." class="form-control w-auto">
    <select name="estado" class="form-control w-auto">
        <option value="">-- Estado --</option>
        <option value="Pagada" {{ request('estado') == 'Pagada' ? 'selected' : '' }}>Pagada</option>
        <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
         <option value="Parcialmente" {{ request('estado') == 'Parcialmente' ? 'selected' : '' }}>Parcialmente Pagada</option>
    </select>
    <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control w-auto">
    <button type="submit" class="btn btn-secondary">Filtrar</button>

    <a href="{{route('facturas.index')}}" class="btn btn-outline-danger">Limpiar filtros</a>

</form>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Cliente</th>
            <th>Importe</th>
            <th>Periodo</th>
             <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturas as $factura)
         <tr>
            <td>{{ $factura->numero_factura }}</td>
            <td>{{ $factura->cliente->razon_social }}</td>
            <td>${{ number_format($factura->importe_total, 2, ',', '.') }}</td>
            <td>{{ $factura->fecha_desde }} - {{ $factura->fecha_hasta }}</td>
           <td>
                @php 
                    $totalPagado = $factura->pagos->sum('monto');
                @endphp

                 @if($totalPagado == 0)
                        <span class="badge badge-warning">Pendiente</span>
                    @elseif($totalPagado >= $factura->importe_total)
                        <span class="badge badge-success">Pagada</span>
                    @else
                        <span class="badge badge-info">Parcialmente pagada</span>
                 @endif
            </td>

            <td>
                @can('editar-facturas')
                    <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-info btn-sm">Editar</a>
                @endcan
                
                @can('descargar-facturas')
                    <a href="{{ asset('storage/factura_' . $factura->id . '.pdf') }}" target="_blank" class="btn btn-secondary btn-sm">PDF</a>
                @endcan
                
                @can('enviar-facturas')
                     <a href="{{ route('facturas.enviar-pdf', $factura->id) }}" class="btn btn-warning btn-sm"
                    onclick="return confirm('¿Enviar esta factura por correo electrónico?')">
                    Enviar por Mail
                </a>
                 @endcan
                
                @can('borrar-facturas')
                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar factura?')">Borrar</button>
                 </form>
                @endcan

                @can('crear-pagos')
                    @if ($totalPagado < $factura->importe_total)
                    <a href="{{ route('pagos.create.from.factura', $factura->id) }}" class="btn btn-success btn-sm">Pagar</a>
                    @endif
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3">
    @if($deudaTotal !== null)
        <div>
            <span class="badge bg-danger p-2" style="font-size: 1.1rem;">
                Deuda total del cliente: ${{ number_format($deudaTotal, 2) }}
            </span> 
        </div>
    @endif
</div>


<div class="pagination justify-content-end">
    {!! $facturas->links() !!}
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop