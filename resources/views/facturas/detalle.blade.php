@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Detalles de la factura</h1>
@stop

@section('content')
  <div class="card shadow border rounded">
    <div class="card-body" style="font-size: 1.1rem;"> {{-- Aumentamos el tamaño de texto --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
                <p><strong>Importe Total:</strong> ${{ number_format($factura->importe_total, 2, ',', '.') }}</p>
                <p><strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i') }}</p>
                <p><strong>Detalle del servicio:</strong> {{ $factura->detalle }}</p>
                <p><strong>Estado:</strong>
                    @php $estado = $factura->estado(); @endphp
                    @if ($estado == 'Pendiente')
                        <span class="badge badge-warning">Pendiente</span>
                    @elseif ($estado == 'Pagada')
                        <span class="badge badge-success">Pagada</span>
                    @elseif ($estado == 'Cancelada')
                        <span class="badge badge-danger">Cancelada</span>
                    @else
                        <span class="badge badge-info">Parcialmente Pagada</span>
                    @endif
                </p>
           

            
                <p><strong>Cliente:</strong> {{ $factura->cliente->razon_social }}</p>
                <p><strong>Condición de Pago:</strong> {{ $factura->condicion_pago }}</p>
                <p><strong>Periodo:</strong> 
                    {{ \Carbon\Carbon::parse($factura->fecha_desde)->format('d/m/Y H:i') }} -
                    {{ \Carbon\Carbon::parse($factura->fecha_hasta)->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        {{-- Botones de acciones --}}
        <td>
        <div class="d-flex flex-wrap gap-3">
            @can('editar-facturas')
                <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-info">Editar</a>
            @endcan

            @can('descargar-facturas')
                <a href="{{ asset('storage/factura_' . $factura->id . '.pdf') }}" target="_blank" class="btn btn-secondary">PDF</a>
            @endcan

            @can('enviar-facturas')
                <a href="{{ route('facturas.enviar-pdf', $factura->id) }}" onclick="return confirm('¿Enviar esta factura por correo?')" class="btn btn-warning">Enviar por Mail</a>
            @endcan

            @can('borrar-facturas')
                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('¿Cancelar factura?')">Cancelar</button>
                </form>
            @endcan
         </div>
        </td>
    </div>
</div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop