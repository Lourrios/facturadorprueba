<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 180px;
            margin-bottom: 10px;
        }
        .datos-empresa {
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ public_path('public\logo\logo.png') }}" class="logo" alt="Vida Digital">
        <div class="datos-empresa">
            <p class="bold">VIDA DIGITAL S.R.L.</p>
            <p>CUIT: 30-71645899-3</p>
            <p>Dirección: Corrientes 1122, Goya, Corrientes</p>
            <p>Email: contacto@vidadigital.com.ar</p>
            <p>Tel: 3777-432100</p>
        </div>
    </div>

    <hr>

    <h3>Factura Nº {{ $factura->numero_factura }}</h3>

    <p><strong>Cliente:</strong> {{ $factura->cliente->razon_social }}</p>
    <p><strong>CUIT:</strong> {{ $factura->cliente->cuit }}</p>
    <p><strong>Condición IVA:</strong> {{ $factura->cliente->condicion_iva }}</p>
    <p><strong>Periodo Facturado:</strong> {{ $factura->periodo_mes }}/{{ $factura->periodo_anio }}</p>
    <p><strong>Desde:</strong> {{ \Carbon\Carbon::parse($factura->fecha_desde)->format('d/m/Y') }} <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($factura->fecha_hasta)->format('d/m/Y') }}</p>
    <p><strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</p>
    <p><strong>Condición de Pago:</strong> {{ $factura->condicion_pago }}</p>

    <table>
        <thead>
            <tr>
                <th>Detalle del Servicio</th>
                <th>Importe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $factura->detalle }}</td>
                <td>$ {{ number_format($factura->importe_total, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>Total:</strong> $ {{ number_format($factura->importe_total, 2, ',', '.') }}</p>

    <div class="footer">
        <hr>
        <p>Gracias por confiar en Vida Digital</p>
        <p><small>Documento generado el {{ now()->format('d/m/Y H:i') }}</small></p>
    </div>
</div>
</body>
</html>
