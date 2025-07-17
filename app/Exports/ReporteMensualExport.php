<?php

namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteMensualExport implements FromCollection, WithHeadings
{
    protected $clienteId;
    protected $mes;
    protected $anio;

    public function __construct($clienteId, $mes, $anio)
    {
        $this->clienteId = $clienteId;
        $this->mes = $mes;
        $this->anio = $anio;
    }

    public function collection()
    {
        $facturas = Factura::with(['pagos', 'cliente'])
            ->where('cliente_id', $this->clienteId)
            ->whereYear('fecha_emision', $this->anio)
            ->whereMonth('fecha_emision', $this->mes)
            ->get();

        return $facturas->map(function ($f) {
            $pagado = $f->pagos->sum('monto');
            $saldo = $f->importe_total - $pagado;

            return [
                'Número' => $f->numero_factura,
                'Fecha de Emisión' => $f->fecha_emision,
                'Detalle' => $f->detalle,
                'Importe Total' => number_format($f->importe_total, 2, ',', '.'),
                'Pagado' => number_format($pagado, 2, ',', '.'),
                'Saldo' => number_format($saldo, 2, ',', '.'),
                'Estado' => $f->estado(),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Número',
            'Fecha de Emisión',
            'Detalle',
            'Importe Total',
            'Pagado',
            'Saldo',
            'Estado',
        ];
    }
}
