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

        .tipo-factura-central {
            text-align: center;
            margin-bottom: 10px;
        }

        .factura-tipo {
            font-size: 50px;
            font-weight: bold;
            border: 2px solid #000;
            width: 50px;
            height: 50px;
            line-height: 50px;
            border-radius: 5px;
            margin: 0 auto 5px auto;
        }

        .factura-numero {
            font-size: 14px;
            font-weight: bold;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .fecha-emision-superior {
            font-size: 12px;
            margin-bottom: 5px;
            text-align: right;
        }

        .logo {
            width: 250px;
        }

        .info-empresa {
            font-size: 11px;
            line-height: 1.4;
            margin-top: 5px;
        }

        .datos-empresa {
            text-align: right;
            font-size: 12px;
            line-height: 1.4;
        }

        .datos-cliente{
            border: 1px solid #333;
            padding: 10px;
            border-radius: 4px;
            font-size: 12px;
            background-color: #f9f9f9;
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

        .footer {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">

    <!-- FACTURA TIPO Y NUMERO CENTRADO -->
    <div class="tipo-factura-central">
        <div class="factura-tipo">{{ substr($factura->numero_factura, 0, 1) }}</div>
        <div class="factura-numero">Factura Nº {{ $factura->numero_factura }}</div>
    </div>

    <!-- ENCABEZADO CON LOGO E INFORMACIÓN -->
    <div class="header">
        <!-- Logo + contacto -->
        <div>
            <img src="{{ public_path('logo/logo.png') }}" class="logo" alt="Logo Vida Digital">
            <div class="info-empresa">
                <strong>VIDA DIGITAL S.R.L.</strong><br>
                contacto@vidadigital.com.ar<br>
                Corrientes 1122, Goya<br>
                Tel: 3777-432100
            </div>
        </div>

        <div class="datos-empresa">
            <div class="fecha-emision-superior">
                <strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
            </div>
            <br>
            <strong>VIDA DIGITAL S.R.L.</strong><br>
            CUIT: 30-71645899-3<br>
            Condición IVA: Responsable Inscripto<br>
            Punto de Venta: 0001
        </div>

    </div>

    <hr>

    <div class="datos-cliente">
        <p><strong>Cliente:</strong> {{ $factura->cliente->razon_social }}</p>
        <p><strong>CUIT:</strong> {{ $factura->cliente->cuit }}</p>
        <p><strong>Condición IVA:</strong> {{ $factura->cliente->condicion_iva }}</p>
        <p><strong>Desde:</strong> {{ \Carbon\Carbon::parse($factura->fecha_desde)->format('d/m/Y') }}
            <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($factura->fecha_hasta)->format('d/m/Y') }}</p>
        <p><strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</p>
        <p><strong>Condición de Pago:</strong> {{ $factura->condicion_pago }}</p>
    </div>

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
