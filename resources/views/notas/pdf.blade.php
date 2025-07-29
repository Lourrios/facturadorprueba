@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota {{ ucfirst($nota->tipo) }} Nº {{ $nota->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header, .footer { text-align: center; }
        .container { width: 100%; margin: 0 auto; padding: 10px; }
        .title { font-size: 16px; font-weight: bold; text-align: center; }
        .box { border: 1px solid #000; padding: 10px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>NOTA DE {{ strtoupper($nota->tipo) }} </h2>
            <p><strong>Nº:</strong> {{ str_pad($nota->id, 8, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Fecha:</strong> {{ Carbon::parse($nota->created_at)->format('d/m/Y') }}</p>
        </div>

        <div class="box">
            <p><strong>Razón Social:</strong> {{ $nota->factura->cliente->razon_social }}</p>
            <p><strong>Dirección:</strong> {{ $nota->factura->cliente->direccion ?? '-' }}</p>
            <p><strong>CUIT:</strong> {{ $nota->factura->cliente->cuit }}</p>
            <p><strong>Condición IVA:</strong> {{ $nota->factura->cliente->condicion_iva }}</p>
            <p><strong>Condición de Venta:</strong> {{ $nota->factura->condicion_pago }}</p>
            <p><strong>Factura Asociada:</strong> {{ $nota->factura->numero_factura }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th class="right">P. Unitario</th>
                    <th class="right">Importe</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $nota->motivo }}</td>
                    <td class="right">${{ number_format($nota->importe, 2, ',', '.') }}</td>
                    <td class="right">${{ number_format($nota->importe, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="right" style="margin-top: 10px;">
            <p><strong>Subtotal:</strong> ${{ number_format($nota->importe, 2, ',', '.') }}</p>
            <p><strong>IVA (0%):</strong> $0,00</p>
            <p><strong>TOTAL:</strong> ${{ number_format($nota->importe, 2, ',', '.') }}</p>
        </div>

        <div class="footer">
            
        </div>
    </div>
</body>
</html>
