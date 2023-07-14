<?php

namespace App\Http\Controllers;

use App\Cuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Recordatorio;
class CuotaController extends Controller
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

    public function cuotas(Request $request)
    {
        $sistema = $request->get('sistema');
        $codigo = $request->get('codigo_oc');
        $data = DB::table('cuotas')
        ->where('codigo_oc', '=', $codigo)
        ->where('sistema', '=', $sistema)
        ->orderby('numero_cuota','ASC')
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
        $codigo_oc = '';
        if (!empty($request->all())) {
            $data=$request->all();
            $firstRow = reset($data);
            $codigo_oc=$firstRow['codigo_oc'];
            Cuota::where('codigo_oc', $codigo_oc)->delete();
        }
        
        foreach ($request->all() as $fila) {
            $responsable = new Cuota($fila);
            $responsable->save();

            $recordatorio = new Recordatorio();
            $recordatorio->asunto='Cuota '.$responsable->numero_cuota;
            $recordatorio->fecha=$responsable->fecha_pago;
            $recordatorio->recordatorio=5;
            $recordatorio->codigo_oc=$codigo_oc;
            $recordatorio->save();

        }
        return response()->json([
            'mensaje' => 'Cuotas registradas.',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function show(Cuota $cuota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuota $cuota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuota $cuota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuota $cuota)
    {
        //
    }
}
