<?php

namespace App\Http\Controllers;

use App\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RecordatorioController extends Controller
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
    public function recordatorios(Request $request)
    {
        $codigo = $request->get('codigo_oc');
        $sistema = $request->get('sistema');
        $data = DB::table('recordatorios')
        ->where('sistema', '=', $sistema)
        ->where('codigo_oc', '=', $codigo)
        ->orderby('id','ASC')
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function show(Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function edit(Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recordatorio  $recordatorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recordatorio $recordatorio)
    {
        //
    }
}
