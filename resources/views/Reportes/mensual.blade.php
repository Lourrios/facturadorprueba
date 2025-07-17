@extends('adminlte::page')

@section('title', 'Reporte Mensual por Cliente')

@section('content_header')
    <h1>Reporte Mensual por Cliente</h1>
@stop

@section('content')
<div class="card p-4">
    <form method="GET" action="{{ route('reportes.mensual') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label>Cliente</label>
            <select name="cliente_id" class="form-control">
                <option value="">Todos los clientes</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $clienteId == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->razon_social }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>Mes</label>
            <input type="number" name="mes" class="form-control" value="{{ $mes }}" min="1" max="12">
        </div>
        <div class="col-md-2">
            <label>Año</label>
            <input type="number" name="anio" class="form-control" value="{{ $anio }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Buscar</button>

            @if($facturas->count() && $clienteId)
                <a href="{{ route('reportes.mensual.exportar', ['cliente_id'=>$clienteId, 'mes'=>$mes, 'anio'=>$anio]) }}"
                   class="btn btn-success">Exportar Excel</a>
            @endif
        </div>
    </form>

    @if($facturas->count())
        @if($clienteId)
            {{-- Modo: cliente seleccionado --}}
            <h5 class="mt-3">Facturas de <strong>{{ $clientes->firstWhere('id', $clienteId)->razon_social }}</strong></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N° Factura</th>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th>Importe</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facturas as $factura)
                        <tr>
                            <td>{{ $factura->numero_factura }}</td>
                            <td>{{ date('d/m/Y', strtotime($factura->fecha_emision)) }}</td>
                            <td>{{ $factura->detalle }}</td>
                            <td>${{ number_format($factura->importe_total, 2, ',', '.') }}</td>
                            <td>${{ number_format($factura->pagos->sum('monto'), 2, ',', '.') }}</td>
                            <td>
                                ${{ number_format($factura->importe_total - $factura->pagos->sum('monto'), 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- Modo: todos los clientes --}}
            @foreach($facturas->groupBy('cliente_id') as $clienteIdGroup => $facturasCliente)
                @php $cliente = $clientes->firstWhere('id', $clienteIdGroup); @endphp
                <h5 class="mt-4">Cliente: <strong>{{ $cliente->razon_social }}</strong></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>N° Factura</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Importe</th>
                            <th>Pagado</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facturasCliente as $factura)
                            <tr>
                                <td>{{ $factura->numero_factura }}</td>
                                <td>{{ date('d/m/Y', strtotime($factura->fecha_emision)) }}</td>
                                <td>{{ $factura->detalle }}</td>
                                <td>${{ number_format($factura->importe_total, 2, ',', '.') }}</td>
                                <td>${{ number_format($factura->pagos->sum('monto'), 2, ',', '.') }}</td>
                                <td>
                                    ${{ number_format($factura->importe_total - $factura->pagos->sum('monto'), 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
    @else
        <div class="alert alert-info mt-3">No hay facturas para mostrar en el período seleccionado.</div>
    @endif
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop