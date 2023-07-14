<?php

namespace App\Http\Controllers;

use App\Socio;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //usar rando 10 
        $limit = $request->get('limit');
        //Order
        $columna = $request->get('columna');
        $order = $request->get('order');
        $filter = $request->get('filter');
        $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');
        $data = Socio::where($columna, 'like', $ff)
                ->orderBy($columna,$order)->paginate($limit);
        return response()->json(['data'=>$data], 200); 
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
            // 'pais' => 'required|string',
            // 'ciudad' => 'required|string',
            // 'direccion' => 'required|string'
        ]);
        $data = $request->all();
        Socio::create([
            'nombre' => $data['nombre'],
            'pais' => $data['pais'],
            'ciudad' => $data['ciudad'],
            'direccion' => $data['direccion'],
            'web' => $data['web'],
            'contacto' => $data['contacto'],
            'telefono' => $data['telefono'],
            'celular' => $data['celular'],
            'email' => $data['email'],
            'nit' => $data['nit']
        ]);

        $mensaje = "Registrado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function show(Socio $socio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(Socio $socio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socio $socio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // 'pais' => 'required|string',
            // 'ciudad' => 'required|string',
            // 'direccion' => 'required|string'
        ]);
        $requestData = $request->all();
        $socio->update($requestData);
        $mensaje = "Actualizado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        //
    }
}
