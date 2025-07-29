@component('mail::message')
# ¡Hola, {{ $factura->cliente->razon_social }}!

Se generó una nueva factura.

@if ($factura->recurrente)
### Total:
<del style="color: #999;">${{ number_format($factura->importe_original, 2, ',', '.') }}</del>  
<span style="color: #28a745; font-weight: bold;">
    ${{ number_format($factura->importe_total, 2, ',', '.') }}
</span>  
<span style="color: #6c757d; font-size: 0.9em;">{{ $factura->descuento_aplicado }}% OFF</span>
@else
### Total:
**${{ number_format($factura->importe_total, 2, ',', '.') }}**
@endif

### Detalles:
- **Fecha de emisión:** {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i') }}
- **Período:** {{ \Carbon\Carbon::parse($factura->fecha_desde)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($factura->fecha_hasta)->format('d/m/Y') }}

Adjuntamos el PDF de la factura en este correo.

Gracias por confiar en **Vida Digital**,  
**VIDA DIGITAL**
@endcomponent
