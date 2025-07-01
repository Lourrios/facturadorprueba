<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:ver-clientes|crear-clientes|editar-clientes|borrar-clientes', ['only' => ['index']]);
         $this->middleware('permission:crear-clientes', ['only' => ['create','store']]);
         $this->middleware('permission:editar-clientes', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-clientes', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $clientes = Cliente::buscar($request->input('buscar'))
                    ->where('activo', true)
                    ->paginate(5);

        return view('clientes.index', compact('clientes'));
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
            'cuil' => 'required|numeric|digits_between:10,11|unique:clientes,cuil',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'condicion_iva' => 'required|in:Responsable Inscripto,Monotributista,Exento,Consumidor Final',
            'email' => 'required|email|unique:clientes,email'
        ]);
    
        Cliente::create($request->all());
    
        return redirect()->route('clientes.index');
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
        $cliente = Cliente::find($id);
        return view('clientes.editar',compact('cliente'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'cuil' => 'required|numeric|digits_between:10,11|unique:clientes,cuil,' . $id,
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'condicion_iva' => 'required|in:Responsable Inscripto,Monotributista,Exento,Consumidor Final',
            'email' => 'required|email|unique:clientes,email,' . $id

            //Ejemplo: SELECT * FROM clientes WHERE email = 'correo@ejemplo.com' AND id != $id

        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        $cliente->activo = false;
        $cliente->save();

        return redirect()->route('clientes.index');
    }
}
