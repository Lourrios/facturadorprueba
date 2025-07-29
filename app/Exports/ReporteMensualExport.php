<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Factura;

class ReporteMensualExport implements FromCollection, WithHeadings
{
    protected $clienteId, $mes, $anio;

    public function __construct($clienteId, $mes, $anio)
    {
        $this->clienteId = $clienteId;
        $this->mes = $mes;
        $this->anio = $anio;
    }

    public function collection()
    {
        $facturas = Factura::with('pagos')
            ->where('cliente_id', $this->clienteId)
            ->whereYear('fecha_emision', $this->anio)
            ->whereMonth('fecha_emision', $this->mes)
            ->get();

        return $facturas->map(function ($f) {
            $pagado = $f->pagos->sum('monto');
            $saldo = $f->importe_total - $pagado;

            return [
                $f->numero_factura,
                optional($f->fecha_emision)->format('d/m/Y'),
                $f->detalle,
                number_format((float) $f->importe_total, 2, ',', '.'),
                number_format((float) $pagado, 2, ',', '.'),
                number_format((float) $saldo, 2, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N° Factura',
            'Fecha de Emisión',
            'Detalle',
            'Importe Total',
            'Pagado',
            'Saldo',
        ];
    }
}