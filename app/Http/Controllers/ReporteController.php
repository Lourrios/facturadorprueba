<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Cliente;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportesExport;
use App\Exports\ReporteMensualExport;



class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $anio = $request->input('anio', date('Y'));

        $clientes = Cliente::with(['facturas' => function ($q) use ($anio) {
            $q->whereYear('fecha_emision', $anio)->with('pagos');
        }])->get();

        $meses = [
            '01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr',
            '05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago',
            '09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dic'
        ];

        return view('reportes.index', compact('clientes','meses','anio'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     public function exportarExcel(Request $request)
    {
        $anio = $request->input('anio', date('Y'));
        return Excel::download(new ReportesExport($anio), "reportes_$anio.xlsx");
    }

    public function reporteMensual(Request $request)
        {
            $clientes = Cliente::all();
            $clienteId = $request->input('cliente_id');
            $mes = $request->input('mes', now()->format('m'));  // Mes actual por defecto
            $anio = $request->input('anio', now()->format('Y')); // Año actual por defecto

            $facturas = Factura::with('pagos', 'cliente')
                ->whereYear('fecha_emision', $anio)
                ->whereMonth('fecha_emision', $mes)
                ->when($clienteId, function ($q) use ($clienteId) {
                    $q->where('cliente_id', $clienteId);
                })
                ->get();

            return view('reportes.mensual', compact('clientes', 'facturas', 'clienteId', 'mes', 'anio'));

        }

    public function exportarReporteMensual(Request $request)
        {
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'mes' => 'required|integer|min:1|max:12',
                'anio' => 'required|integer|min:2000',
            ]);

            $clienteId = $request->cliente_id;
            $mes = $request->mes;
            $anio = $request->anio;

            return \Maatwebsite\Excel\Facades\Excel::download(
                new ReporteMensualExport($clienteId, $mes, $anio),
                "reporte_mensual_{$anio}_{$mes}.xlsx"
            );
        }
}
