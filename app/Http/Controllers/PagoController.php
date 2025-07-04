<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function __construct() {
        
        $this->middleware('permission:ver-pagos', ['only' => ['index']]);
        $this->middleware('permission:crear-pagos', ['only' => ['create','store']]);
        $this->middleware('permission:editar-pagos', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-pagos', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $pagos = Pago::with('factura')
        ->when($busqueda, function($query, $busqueda) {
            return $query->where('fecha_pago', 'like', "%$busqueda%")
                        ->orWhere('metodo_pago', 'like', "$busqueda")
                        ->orWhereHas('factura', function ($q) use ($busqueda) {
                            $q->where('numero_factura', 'like', "$busqueda");  
                        });
        })->orderBy('id', 'desc')
        ->paginate(5);

        
        return view('pagos.index', compact('pagos','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pagos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'monto' => 'required|numeric|min:0|max:99999999.99',
            'metodo_pago' => 'required|in:Efectivo,Transferencia,Cheque,Tarjeta',
            'observaciones' => 'nullable',
            'numero_factura' => ['required', 'regex:/^[ABC]\d{6}$/', Rule::exists('facturas', 'numero_factura')],
            
          ]);

        $factura = Factura::where('numero_factura', $request->numero_factura)->first();

        if ($request->monto > $factura->importe_total) {
            return back()
                ->withErrors(['monto' => 'El monto ingresado no puede ser mayor al total de la factura ($' . number_format($factura->importe_total, 2) . ').']
                )->withInput();
        }   
          
       
        $ahora = Carbon::now();

        $pago = new Pago();
        $pago->monto = $request->monto;
        $pago->fecha_pago = $ahora->toDateTimeString();
        $pago->metodo_pago = $request->metodo_pago;
        $pago->observaciones = $request->observaciones;
        $pago->factura_id = $factura->id;
        $pago->save();

        return redirect()->route('pagos.index')->with('success', 'Se ha ingresado el pago.');
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
        $pago = Pago::findOrFail($id);

        return view('pagos.edit', compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);
        $request->validate([
        'monto'=>'required|numeric|min:0|max:99999999.99',
        'metodo_pago'=>'required|in:Efectivo,Transferencia,Cheque,Tarjeta',
        'observaciones'=>'nullable',
        ]);

        $pago->update([
            'monto'=>$request->monto,
            'metodo_pago'=> $request->metodo_pago,
            'observaciones'=> $request->observaciones,
        ]);

        return redirect() ->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');

    }
}
