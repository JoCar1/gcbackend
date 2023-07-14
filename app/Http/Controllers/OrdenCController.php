<?php

namespace App\Http\Controllers;

use App\OrdenC;
use Illuminate\Http\Request;

class OrdenCController extends Controller
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
        $contrato = new OrdenC($request->all());
        $contrato->save();
        
        return response()->json([
            'mensaje' => 'Contrato guardado exitosamente',
            'contrato' => $contrato
        ], 201);

        // $request->validate([
        //     'nombre' => 'required|string|max:255',
        //     'nit' => 'required|string|unique:proveedoresc',
        // ]);
        // $data= new ProveedorC();
        // $data = $request->all();

        // ProveedorC::create([
        //     'nit' => $data['nit'],
        //     'nombre' => $data['nombre'],
        //     'telefono' => $data['telefono'],
        //     'fax' => $data['fax'],
        //     'celular' => $data['celular'],
        //     'direccion' => $data['direccion'],
        //     'servicio' => $data['servicio']
        // ]);  
        

        // $mensaje = "Registrado correctamente";
        // return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrdenC  $ordenC
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenC $ordenC)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrdenC  $ordenC
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenC $ordenC)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdenC  $ordenC
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenC $ordenC)
    {
        $contrato = OrdenC::find($id);
        $contrato->update($request->all());

        return response()->json(['mensaje' => 'Contrato actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdenC  $ordenC
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenC $ordenC)
    {
        //
    }
}
