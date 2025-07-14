<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaGenerada;
use Carbon\Carbon;

class FacturaService
{
    public function generarNumeroFactura(Cliente $cliente): string
    {
        $prefijo = $cliente->condicion_iva === 'Responsable Inscripto' ? 'A' : 'B';

        $ultima = Factura::where('numero_factura', 'like', $prefijo . '%')
            ->orderBy('id', 'desc')
            ->first();

        $ultimoNumero = $ultima ? intval(substr($ultima->numero_factura, 1)) : 0;
        $nuevoNumero = $ultimoNumero + 1;

        return $prefijo . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
    }

    public function calcularImporteConBonificacion(Cliente $cliente, float $base): array
    {
        $descuento = $cliente->obtenerDescuentoPorMembresia(); // método en modelo
        $importeFinal = round($base * (1 - $descuento), 2);

        return [
            'importe' => $importeFinal,
            'descuento' => $descuento * 100
        ];
    }

    public function crearFactura(Cliente $cliente, float $importe, float $descuento, string $numero): Factura
    {
        
        $ahora = now();
        $inicioMes = $ahora->copy()->startOfMonth();
        $inicioMembresia = \Carbon\Carbon::parse($cliente->fecha_membresia);
        $fechaDesde =  $inicioMembresia->greaterThan($inicioMes)
                ? $inicioMembresia->toDateString()
                : $inicioMes->toDateString();
        $fechaHasta = \Carbon\Carbon::parse($fechaDesde)->addDays(24)->toDateString();


        
        return Factura::create([
            'cliente_id' => $cliente->id,
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'detalle' => 'Servicio mensual de membresía',
            'importe_total' => $importe,
            'condicion_pago' => 'Contado',
            'numero_factura' => $numero,
            'fecha_emision' => $ahora->toDateTimeString(),
            'descuento_aplicado' => $descuento,
            'activo' => 1,
        ]);

    }

    public function enviarFacturaPorMail(Factura $factura): void
    {
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
        $pdf->save(storage_path("app/public/factura_{$factura->id}.pdf"));
        $pdfData = $pdf->output();

        Mail::to($factura->cliente->email)->send(new FacturaGenerada($factura, $pdfData));
    }
}
