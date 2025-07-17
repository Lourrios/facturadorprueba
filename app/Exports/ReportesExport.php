<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ReportesExport implements FromCollection, WithHeadings
{
    protected $anio;

    public function __construct($anio) { $this->anio = $anio; }

    public function collection()
    {
        $clientes = Cliente::with(['facturas' => function ($q) {
            $q->whereYear('fecha_emision', $this->anio)->with('pagos');
        }])->get();

        $rows = collect();

        foreach ($clientes as $cliente) {
            $row = ['Cliente' => $cliente->razon_social];

            for ($m = 1; $m <= 12; $m++) {
                $mes = str_pad($m, 2, '0', STR_PAD_LEFT);

                // Filtramos facturas por mes según fecha_emision
                $facturasMes = $cliente->facturas->filter(function ($factura) use ($mes) {
                    return Carbon::parse($factura->fecha_emision)->format('m') === $mes;
                });

                $totalFacturado = $facturasMes->sum('importe_total');
                $pagado = $facturasMes->flatMap->pagos->sum('monto');
                $saldo = $totalFacturado - $pagado;

                $row[$mes] = round($saldo, 2);
            }

            $rows->push($row);
        }

        return $rows;
    }

    public function headings(): array
    {
         return [
            'Cliente', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
        ];
    }
}
