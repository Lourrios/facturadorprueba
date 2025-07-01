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

        $clientes= Cliente::when($busqueda, function($query, $busqueda){
            return $query->where('razon_social','like',"%$busqueda%")
            ->orwhere('cuit','like', "%$busqueda%");

        })->paginate(5);
        
        return view('clientes.index', compact('clientes','busqueda'));

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
        $request->validate([
            'cuit' => 'required|unique:clientes',
            'razon_social' => 'required',
            'direccion' => 'required',
            'email' => 'required|email',
            'telefono' => 'nullable',
            'condicion_iva' => 'required',
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

        $request->validate([
            'cuit' => 'required|unique:clientes,cuit,'.$id,
            'razon_social' => 'required',
            'direccion' => 'required',
            'email' => 'required|email',
            'telefono' => 'nullable',
            'condicion_iva' => 'required',
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
