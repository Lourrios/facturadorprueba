@component('mail::message')
# ¡Hola!

Se generó una nueva factura para **{{ $factura->cliente->razon_social }}**.

- **Número:** {{ $factura->numero_factura }}
- **Importe:** ${{ number_format($factura->importe_total, 2, ',', '.') }}
- **Periodo:** {{ $factura->periodo_mes }}/{{ $factura->periodo_anio }}

Adjuntamos el PDF correspondiente.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
