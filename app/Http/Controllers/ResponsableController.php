<?php

namespace App\Http\Controllers;

use App\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ResponsableController extends Controller
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
    public function responsables(Request $request)
    {
        $codigo = $request->get('codigo');
        $sistema = $request->get('sistema');
        $responsabilidad = $request->get('responsabilidad');
        // echo  $codigo.$responsabilidad;
        $data = DB::table('responsables')
        ->join('users', 'users.id', '=', 'responsables.user_id')
        ->select('users.nombre','responsables.*')
        ->where('responsables.codigo_oc', '=', $codigo)
        ->where('responsables.sistema', '=', $sistema)
        ->where('responsables.responsabilidad', '=', $responsabilidad)
        ->get();

       return response()->json($data, 200); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $responsable = new Responsable($request->all());
        $responsable->save();
        
        return response()->json([
            'mensaje' => 'Responsable agregado.',
            'responsable' => $responsable
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Responsable  $responsable
     * @return \Illuminate\Http\Response
     */
    public function show(Responsable $responsable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Responsable  $responsable
     * @return \Illuminate\Http\Response
     */
    public function edit(Responsable $responsable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Responsable  $responsable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responsable $responsable)
    {
        //
    }

    public function destroy($id)
    {
        // $id = $request->get('id');
        $responsable = Responsable::find($id);

        if (!$responsable) {
            return response()->json(['mensaje' => 'El responsable no existe'], 404);
        }

        $responsable->delete();

        return response()->json(['mensaje' => 'Responsable removido'], 200);
    }
}
