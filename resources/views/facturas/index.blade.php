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

  <div class="d-flex align-items-center flex-wrap">

        <input type="text" name="cliente" id="cliente-buscador"
            value="{{ request('cliente') }}" placeholder="Buscar Cliente..."
            class="form-control w-auto mr-2 mb-2">

        <select name="estado" class="form-control w-auto mr-2 mb-2">
            <option value="">-- Estado --</option>
            <option value="Pagada" {{ request('estado') == 'Pagada' ? 'selected' : '' }}>Pagada</option>
            <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="Cancelada" {{ request('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
        </select>

        <input type="date" name="fecha" value="{{ request('fecha') }}"
            class="form-control w-auto mr-2 mb-2">

        <button type="submit" class="btn btn-secondary mr-2 mb-2">Filtrar</button>

        <a href="{{ route('facturas.index') }}" class="btn btn-outline-danger mb-2">Limpiar filtros</a>

    </div>



</form>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Cliente</th>
            <th>Importe Adeudado</th>
            <th>Periodo</th>
             <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturas as $factura)
                @php 
                    $totalPagado = $factura->pagos->sum('monto');
                @endphp
         <tr>
            <td>{{ $factura->numero_factura }}</td>
            <td>{{ $factura->cliente->razon_social }}</td>
            <td>${{ number_format($factura->importe_total - $totalPagado, 2, ',', '.') }}</td>
            <td>{{ $factura->fecha_desde }} - {{ $factura->fecha_hasta }}</td>
           <td>

                @if($totalPagado == 0)  
                    <span class="badge badge-warning">Pendiente</span>
                @elseif($totalPagado >= $factura->importe_total)
                    <span class="badge badge-success">Pagada</span>
                @elseif($factura->activa === 0)
                    <span class="badge badge-danger">Cancelada</span>
                @else
                    <span class="badge badge-info">Parcialmente Pagada</span>
                @endif
            </td>

            <td>
                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-primary btn-sm">Ver factura</a>

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