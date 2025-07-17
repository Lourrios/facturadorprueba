@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   <h1>Reporte de Facturas por Cliente — Año {{ $anio }}</h1>
@stop

@section('content')
  <div class="mb-3">
    <form method="GET" action="{{ route('reportes.index') }}" class="form-inline">
        <label class="mr-2">Año:</label>
        <input type="number" name="anio" value="{{ $anio }}" class="form-control mr-2" style="width:100px;">
        <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
        <a href="{{ route('reportes.exportarExcel', ['anio' => $anio]) }}" class="btn btn-success">Exportar Excel</a>
    </form>
</div>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Cliente</th>
            @foreach($meses as $m) <th>{{ $m }}</th> @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->razon_social }}</td>
                @foreach(array_keys($meses) as $mes)
                    @php
                        $facturasMes = $cliente->facturas->filter(function ($f) use ($mes) {
                            return \Carbon\Carbon::parse($f->fecha_emision)->format('m') === $mes;
                        });

                        $total = $facturasMes->sum('importe_total');
                        $pagado = $facturasMes->flatMap->pagos->sum('monto');
                        $saldo = $total - $pagado;

                        $color = $saldo > 0
                            ? ($pagado > 0 ? 'background:yellow' : 'background:red')
                            : 'background:lightgreen';
                    @endphp
                    <td style="{{ $color }}">{{ number_format($saldo, 2, ',', '.') }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop