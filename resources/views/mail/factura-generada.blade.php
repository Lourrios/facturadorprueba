@component('mail::message')
# ¡Hola, {{ $factura->cliente->razon_social }}!

Se generó una nueva factura.

- **Total:** ${{ number_format($factura->importe_total, 2) }}
- **Fecha Emisión:** {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i') }}
- **Periodo:** {{ $factura->fecha_desde }}  /  {{ $factura->fecha_hasta }}

Adjuntamos el PDF de la factura en este correo.

Gracias por confiar en Vida Digital,<br>
VIDA DIGITAL
@endcomponent
