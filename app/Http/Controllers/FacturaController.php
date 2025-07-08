<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaGenerada;
use Carbon\Carbon;

class FacturaController extends Controller
{
      public function __construct()
    {
        $this->middleware('permission:ver-facturas|crear-facturas|editar-facturas|borrar-facturas',['only' => ['index']]);
        $this->middleware('permission:crear-facturas', ['only' => ['create','store']]);
        $this->middleware('permission:editar-facturas', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-facturas', ['only' => ['destroy']]);
        $this->middleware('permission:descargar-facturas', ['only' => ['descargarPDF']]);
        $this->middleware('permission:enviar-facturas', ['only' => ['enviarPorCorreo']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $cliente = $request->input('cliente');
        $estado = $request->input('estado');
        $fecha = $request->input('fecha');


        $query = Factura::with(['cliente', 'pagos'])

        ->when($cliente, function ($q) use ($cliente) {
            $q->whereHas('cliente', function ($subQuery) use ($cliente) {
                $subQuery->where('razon_social', 'like', "%$cliente%");
            });
        })
        ->when($fecha, function ($q) use ($fecha) {
            $q->whereDate('fecha_emision', $fecha);
        })
        ->orderBy('fecha_emision', 'desc');;


        //Filtro de facturas segun el estado
        $facturas = $query->get()->filter(function ($factura) use ($estado) {
            return !$estado || $factura->estado() === $estado;
        });


        // Paginar manualmente
        $page = request()->get('page', 1);
        $perPage = 5;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $facturas->forPage($page, $perPage),
            $facturas->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $facturas = $paginated;


        $deudaTotal = null;

        if ($cliente) {
            // Buscar al cliente filtrado y traer sus facturas con pagos
            $clienteEncontrado = \App\Models\Cliente::where('razon_social', 'like', "%$cliente%")
                ->with(['facturas.pagos'])
                ->first();

            if ($clienteEncontrado) {
                $deudaTotal = $clienteEncontrado->facturas->reduce(function ($carry, $factura) {
                    $pagado = $factura->pagos->sum('monto');
                    $deuda = $factura->importe_total - $pagado;

                    return $carry + max($deuda, 0);
                }, 0);

            }
        }


        return view('facturas.index', compact('facturas', 'deudaTotal'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

         $clientes= Cliente::all();
        return view('facturas.crear', compact('clientes'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
             'cliente_id' => 'required|exists:clientes,id',
             'fecha_desde' => 'required|date',
             'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
             'detalle' => 'required',
             'importe_total'=> 'required|numeric|min:0',
             'condicion_pago' => 'required',


        ]);
        //GENERACION AUTOMATICA DE NUMERO DE FACTURA
        $cliente = Cliente::findOrFail($request->cliente_id);
        $condicionIva =$cliente->condicion_iva;

        switch($condicionIva) {
            case 'Responsable Inscripto':
                $prefijo = 'A';
                break;

            case 'Monotributo':
            case 'Exento':
            case 'Consumidor Final':
            default:
                $prefijo = 'B';
                break;
        }


        // Busca última factura del tipo (A o C)
        $ultimo = Factura::where('numero_factura', 'like', $prefijo . '%')
            ->orderBy('id', 'desc')
            ->first();

        $ultimoNumero = $ultimo ? intval(substr($ultimo->numero_factura, 1)) : 0;
        $nuevoNumero = $ultimoNumero + 1;

        $numero = $prefijo . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);

        $ahora = Carbon::now();

        $factura = Factura::create([
            ...$request->all(),
            'numero_factura' => $numero,
            'fecha_emision' => $ahora->toDateTimeString(),
        ]);


        $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
        $pdf->save(storage_path("app/public/factura_{$factura->id }.pdf"));

        $pdfData = $pdf->output();

        Mail::to($factura->cliente->email)->send(new FacturaGenerada($factura, $pdfData));

        return redirect()->route('facturas.index')->with('success','Factura creada correctamente.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $factura = Factura::with('cliente')->findOrFail($id);
        return view ('facturas.show', compact('factura'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $factura =Factura::findOrFail($id);
        $clientes = Cliente::all();
        return view('facturas.editar', compact('factura', 'clientes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
             'cliente_id' => 'required|exists:clientes,id', 
             'fecha_desde' => 'required|date',
             'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
             'detalle' => 'required',
             'importe_total'=> 'required|numeric|min:0',
             'fecha_emision' => 'required|date',
             'condicion_pago' => 'required',


        ]);

        $factura = Factura::findOrFail($id);
        $factura->update($request->all());

        return redirect()->route('facturas.index')->with('success', 'Factura actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $factura = Factura::findOrFail($id);
        $factura->activo = 0;
        $factura->save();
        return redirect()->route('facturas.index')->with('success', 'Se ha dado de baja a la factura'. $factura->numero_factura .'.');
    }

    //Descarga del archivo pdf
    public function descargarPDF( $id){
        $factura =Factura::with('cliente')->findOrFail($id);
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
        return $pdf->download("factura_{$factura->id}.pdf");

    }

    public function enviarPorCorreo($id)
{
    $factura = Factura::with('cliente')->findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('facturas.pdf', compact('factura'));
    $pdfData = $pdf->output();

    \Illuminate\Support\Facades\Mail::to($factura->cliente->email)->send(new \App\Mail\FacturaGenerada($factura, $pdfData));

    return redirect()->back()->with('success', 'Factura enviada por correo.');
}

}
