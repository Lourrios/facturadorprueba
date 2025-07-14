@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Detalles de la factura</h1>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif




  <div class="container d-flex justify-content-center">
    <div class="card shadow border rounded w-100" style="max-width: 900px;">
        <div class="card-body" style="font-size: 1.1rem;">

            {{-- Título subrayado --}}
            <h4 class="mb-4" style="border-bottom: 2px solid #ccc; padding-bottom: 5px;">
                Detalles:
            </h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
                    <p><strong>Importe Total:</strong> ${{ number_format($factura->importe_total, 2, ',', '.') }}</p>
                    <p><strong>Fecha de Emisión:</strong> {{ date('d/m/Y H:i', strtotime($factura->fecha_emision)) }}</p>
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
                </div>
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $factura->cliente->razon_social }}</p>
                    <p><strong>Condición de Pago:</strong> {{ $factura->condicion_pago }}</p>
                    <p><strong>Periodo:</strong> 
                        {{ date('d/m/Y H:i', strtotime($factura->fecha_desde)) }} -
                        {{ date('d/m/Y H:i', strtotime($factura->fecha_hasta)) }}
                    </p>
                </div>
            </div>

           
            <hr class="my-4">

            
            <div class="border rounded p-3 bg-light">
                <div class="d-flex flex-wrap gap-2">
                    @can('editar-facturas')
                        <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-info  mb-2 mr-2">Editar</a>
                    @endcan

                    @can('descargar-facturas')
                        <a href="{{ asset('storage/factura_' . $factura->id . '.pdf') }}" target="_blank" class="btn btn-secondary mb-2 mr-2">PDF</a>
                    @endcan

                    @can('enviar-facturas')
                        <a href="{{ route('facturas.enviar-pdf', $factura->id) }}" onclick="return confirm('¿Enviar esta factura por correo?')" class="btn btn-warning me-2 mb-2 mr-2">Enviar por Mail</a>
                    @endcan

                 {{--   @can('borrar-facturas')
                        <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" class="mb-2 me-2 mr-2" onsubmit="return confirm('¿Cancelar factura?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Cancelar</button>
                        </form>
                    @endcan --}}
                
                @can('crear-nota')
                        <div class="dropdown mb-2 me-2">
                            <button class="btn btn-danger dropdown-toggle" type="button" id="notaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Generar Nota
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="notaDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('notas.create.credito', $factura->id) }}">Nota de Crédito</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('notas.create.debito', $factura->id) }}">Nota de Débito</a>
                                </li>
                            </ul>
                        </div>
                    @endcan

                

                </div>
            </div>

        </div>
    </div>
</div>


@stop


@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stop