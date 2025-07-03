

@component('mail::message')
# ¡Hola, {{ $factura->cliente->razon_social }}!

Se genero una nueva factura!

- Total: ${{ number_format($factura->importe_total, 2) }}
- Fecha Emision: {{ $factura->fecha_emision }}
- Periodo: Desde: {{ $factura->fecha_desde }}  /  Hasta:{{ $factura->fecha_hasta }}

Factura {{ $factura->numero_factura }} adjunta en pdf!

Saludos,  
{{ config('app.name') }}
@endcomponent

