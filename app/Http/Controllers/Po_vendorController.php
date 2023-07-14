<?php

namespace App\Http\Controllers;

use App\Po_vendor;
use Illuminate\Http\Request;

class Po_vendorController extends Controller
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
        $filter = strtoupper($request->get('filter'));
        $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');

        $data = Po_vendor::where($columna, 'like', $ff)
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Po_vendor  $po_vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Po_vendor $po_vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Po_vendor  $po_vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Po_vendor $po_vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Po_vendor  $po_vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Po_vendor $po_vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Po_vendor  $po_vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Po_vendor $po_vendor)
    {
        //
    }
}
