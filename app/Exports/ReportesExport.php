<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportesExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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

        // 👉 Negrita para encabezados (fila 1) y primera columna
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true]], // Encabezado fila 1
            'A2:A' . $lastRow => ['font' => ['bold' => true]], // Clientes columna A
        ];
    }

    // 👉 Bordes finos a toda la tabla
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                $range = 'A1:' . $highestCol . $highestRow;

                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }
}
