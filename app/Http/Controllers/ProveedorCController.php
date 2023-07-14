<?php

namespace App\Http\Controllers;

use App\ProveedorC;
use Illuminate\Http\Request;

class ProveedorCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'required|string|unique:proveedoresc',
        ]);
        $data= new ProveedorC();
        $data = $request->all();

        ProveedorC::create([
            'nit' => $data['nit'],
            'nombre' => $data['nombre'],
            'telefono' => $data['telefono'],
            'fax' => $data['fax'],
            'celular' => $data['celular'],
            'direccion' => $data['direccion'],
            'servicio' => $data['servicio']
        ]);  
        

        $mensaje = "Registrado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProveedorC  $proveedorC
     * @return \Illuminate\Http\Response
     */
    public function show(ProveedorC $proveedorC)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProveedorC  $proveedorC
     * @return \Illuminate\Http\Response
     */
    public function edit(ProveedorC $proveedorC)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProveedorC  $proveedorC
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProveedorC $proveedorC)
    {
        $data = $request->all();
        $user = ProveedorC::findOrFail($data['codigo']);
        // $proveedor = ProveedorC::where('codigo', $data['codigo'])->firstOrFail();

       
        $user->celular = $data['celular'];
        $user->direccion = $data['direccion'];
        $user->fax = $data['fax'];
        $user->nit = $data['nit'];
        $user->nombre = $data['nombre'];
        $user->servicio = $data['servicio'];
        $user->telefono = $data['telefono'];
        $user->update();
        $mensaje = "Actualizado correctamente";

        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProveedorC  $proveedorC
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProveedorC $proveedorC)
    {
        //
    }
}
