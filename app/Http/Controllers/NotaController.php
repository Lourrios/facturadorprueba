<?php

namespace App\Http\Controllers;
use App\Models\Nota;
use App\Models\Factura;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Nota::with('factura')->latest()->get();
    return view('notas.index', compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    
    // Formulario para crear nota de crédito
    public function formCredito(Factura $factura)
    {
        return view('notas.crearNotaCredito', compact('factura'));
    }

    // Formulario para crear nota de débito
    public function formDebito(Factura $factura)
    {
        return view('notas.crearNotaDebito', compact('factura'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'factura_id'=>'required|exists:facturas,id',
            'tipo'=> 'required|in:credito,debito',
            'motivo'=>'required|string|max:255',
            'importe'=> 'required|numeric|min:0.01',
        ]);

        $factura = Factura::findOrFail($request->factura_id);

       $nota= Nota::create([
            'factura_id'=>$factura->id,
            'tipo'=>$request->tipo,
            'motivo'=>$request->motivo,
            'importe'=> $request->importe,

        ]);

        // Ajustar importe de la factura
        if ($nota->tipo === 'credito') {
            $factura->importe_total -= $nota->importe;
        } else {
            $factura->importe_total += $nota->importe;
        }

    $factura->save();

    return redirect()->route('facturas.show', $factura->id)
        ->with('success', "Nota de {$nota->tipo} generada con éxito y factura actualizada.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $nota = Nota::with('factura.cliente')->findOrFail($id); // Agregamos la carga de relaciones
            return view('notas.show', compact('nota'));
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

    public function generatePdf(Nota $nota)
    {
        $pdf = Pdf::loadView('notas.pdf', compact('nota'))->setPaper('A4');
        return $pdf->stream("nota_{$nota->id}.pdf");
    }
}
