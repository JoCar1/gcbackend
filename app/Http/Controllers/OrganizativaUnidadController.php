<?php

namespace App\Http\Controllers;

use App\OrganizativaUnidad;
use Illuminate\Http\Request;

class OrganizativaUnidadController extends Controller
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
            'nombre' => 'required|string|max:255'
        ]);
        $data = $request->all();
        OrganizativaUnidad::create([
            'nombre' => $data['nombre']
        ]);

        $mensaje = "Registrado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrganizativaUnidad  $organizativaUnidad
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizativaUnidad $organizativaUnidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrganizativaUnidad  $organizativaUnidad
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizativaUnidad $organizativaUnidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrganizativaUnidad  $organizativaUnidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organizativaUnidad = OrganizativaUnidad::find($id);
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);
        $requestData = $request->all();
        $organizativaUnidad->update($requestData);
        $mensaje = "Actualizado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganizativaUnidad  $organizativaUnidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizativaUnidad $organizativaUnidad)
    {
        //
    }
}
