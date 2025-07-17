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

    public function calcularImporteFinal(float $importeTotal, int $mes): array
    {
        $descuento = match (true) {
            $mes <= 3 => 0.10,
            $mes <= 12 => 0.05,
            default => 0,
        };

        $importeFinal = round($importeTotal * (1 - $descuento), 2);

        return [
            'importe_final' => $importeFinal,
            'descuento' => $descuento * 100,
        ];
    }

    public function crearFactura(Cliente $cliente, float $importeOriginal, float $importeFinal, float $descuento, string $numero, string $detalle): Factura
    {
        $ahora = now();
        $inicioMes = $ahora->copy()->startOfMonth();
        $inicioMembresia = Carbon::parse($cliente->fecha_membresia);
        $fechaDesde = $inicioMembresia->greaterThan($inicioMes)
            ? $inicioMembresia->toDateString()
            : $inicioMes->toDateString();

        $fechaHasta = Carbon::parse($fechaDesde)->addDays(24)->toDateString();

        return Factura::create([
            'cliente_id' => $cliente->id,
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'detalle' => $detalle,
            'importe_total' => $importeFinal, 
            'importe_original' => $importeOriginal, 
            'condicion_pago' => 'Contado',
            'numero_factura' => $numero,
            'fecha_emision' => $ahora->toDateTimeString(),
            'descuento_aplicado' => $descuento,
            'activo' => 1,
            'recurrente' => true,
        ]);
    }

    public function enviarFacturaPorMail(Factura $factura): void
    {
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
        $pdf->save(storage_path("app/public/factura_{$factura->id}.pdf"));
        $pdfData = $pdf->output();

        Mail::to($factura->cliente->email)->send(new FacturaGenerada($factura, $pdfData));
    }

    public function procesarFacturasRecurrentes(): array
    {
        $facturas = Factura::where('recurrente', true)->get();
        $resultado = [];

        foreach ($facturas as $original) {
            $cliente = $original->cliente;

            $existe = Factura::where('recurrente', true)
            ->where('detalle', $original->detalle)
            ->where('cliente_id', $cliente->id)
            ->whereMonth('fecha_emision', now()->month) 
            ->whereYear('fecha_emision', now()->year)
            ->exists();


            if ($existe) {
                continue;
            }

            $repeticiones = Factura::where('cliente_id', $cliente->id)
            ->where('recurrente', true)
            ->where('detalle', $original->detalle)
            ->count();


            $mes = $repeticiones + 1;

            $calculo = $this->calcularImporteFinal($original->importe_original, $mes);
            $numero = $this->generarNumeroFactura($cliente);

            $nueva = $this->crearFactura(
                $cliente,
                $original->importe_original,
                $calculo['importe_final'],
                $calculo['descuento'],
                $numero,
                $original->detalle
            );

            $this->enviarFacturaPorMail($nueva);

            $resultado[] = [
                'factura' => $nueva->numero_factura,
                'email' => $cliente->email,
            ];
        }

        return $resultado;
    }

    public function calcularAntiguedadRecurrente(Factura $factura): int
    {
        $primeraFactura = Factura::where('cliente_id', $factura->cliente_id)
            ->where('recurrente', true)
            ->where('detalle', $factura->detalle)
            ->orderBy('fecha_emision', 'asc')
            ->first();

        if (!$primeraFactura) {
            return 0;
        }

        return \Carbon\Carbon::parse($primeraFactura->fecha_emision)->diffInMonths(now());
    }

    public function contarFacturasImpagas(Factura $factura): int
    {
        return Factura::where('cliente_id', $factura->cliente_id)
            ->where('recurrente', true)
            ->where('detalle', $factura->detalle)
            ->with('pagos')
            ->get()
            ->filter(function ($f) {
                $pagado = $f->pagos->sum('monto');
                return $f->activo === 1 && $pagado < $f->importe_total;
            })
            ->count();
    }

}
