<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-clientes', ['only' => ['index']]);
        $this->middleware('permission:crear-clientes', ['only' => ['create','store']]);
        $this->middleware('permission:editar-clientes', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-clientes', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');
        $estadoDeuda = $request->input('estado_deuda');

        $clientes = Cliente::with('facturas.pagos')
            ->when($busqueda, function ($query, $busqueda) {
                return $query->where('razon_social', 'like', "%$busqueda%")
                            ->orWhere('cuit', 'like', "%$busqueda%");
            })
            ->get()
            ->filter(function ($cliente) use ($estadoDeuda) {
                if (!$estadoDeuda) return true;

                if ($estadoDeuda === 'pagado') {
                    return !$cliente->tieneFacturasAdeudadas();
                } elseif ($estadoDeuda === 'adeudado') {
                    return $cliente->tieneFacturasAdeudadas();
                }

                return true;
            })
            ->values(); // importante para resetear índices

        // 🔽 PAGINADO MANUAL
        $page = $request->input('page', 1);
        $perPage = 5;

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $clientes->forPage($page, $perPage),
            $clientes->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('clientes.index', [
            'clientes' => $paginated,
            'busqueda' => $busqueda,
            'estadoDeuda' => $estadoDeuda,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $this->validate($request, [
            'cuit' => 'required|numeric|digits_between:10,11|unique:clientes,cuit',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'condicion_iva' => 'required|in:Responsable Inscripto,Monotributo,Exento,Consumidor Final',
            'email' => 'required|email|unique:clientes,email'
        ]);
    
        Cliente::create($request->all());
    
       return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');

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

        $cliente = Cliente::findOrFail($id);

          return view('clientes.editar', compact('cliente'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $cliente = Cliente::findOrFail($id);
        $this->validate($request, [
            'cuit' => 'required|numeric|digits_between:10,11|unique:clientes,cuit,' . $id,
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'condicion_iva' => 'required|in:Responsable Inscripto,Monotributo,Exento,Consumidor Final',
            'email' => 'required|email|unique:clientes,email,' . $id

            //Ejemplo: SELECT * FROM clientes WHERE email = 'correo@ejemplo.com' AND id != $id

        ]);

       
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

         $cliente = Cliente::findOrFail($id);
        $cliente->delete(); // Soft delete
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');


    }
}
