<?php

namespace App\Http\Controllers;

use App\Orden;
use App\Proveedor;
use App\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       //usar rando 10 
       $filtro = $request->get('filtro');
       $limit = $request->get('limit');
       //Orderadobe 
       $columna = $request->get('columna');
       if ($columna=='numero') {
        $columna='contratos.numero';
       }
       else{
        $columna='ordenest.'.$columna;
       }
       $order = $request->get('order');
       $filter = strtoupper($request->get('filter'));
       $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');

        // if ($columna=='contratos.numero' && $request->get('filter')=='') {
        //     $data = DB::table('ordenes')
        //     ->leftJoin('contratos', 'ordenes.codigo', '=', 'contratos.codigo_oc')
        //     ->select('*')
        //     ->orderBy($columna,$order)
        //     ->paginate($limit);
        // } else {
        //     $data = DB::table('ordenes')
        //     ->leftJoin('contratos', 'ordenes.codigo', '=', 'contratos.codigo_oc')
        //     ->select('*')
        //     ->where($columna, 'like', $ff)
        //     ->orderBy($columna,$order)
        //     ->paginate($limit);
        // }
        if ($filtro!="ALL") {
            $data = DB::table('ordenest')
            ->leftJoin('contratos', 'ordenest.codigo', '=', 'contratos.codigo_oc')
            ->select('ordenest.*')
            ->where($columna, 'like', $ff)
            ->where('ordenest.sistema', '=', $filtro)
            ->orderBy($columna,$order)
            ->paginate($limit);
        } else {
            $data = DB::table('ordenest')
            ->leftJoin('contratos', 'ordenest.codigo', '=', 'contratos.codigo_oc')
            ->select('ordenest.*')
            ->where($columna, 'like', $ff)
            ->orderBy($columna,$order)
            ->paginate($limit);
        }

        foreach ($data as $key => $value) {
            // //rescata proveedor
            $proveedor= DB::table('proveedores')
            ->where ('codigo','=',$value->provedor)
            ->first();
            // // rescata contrato
            $contrato = Contrato::orderBy('numero','ASC')
            ->where ('codigo_oc','=',$value->codigo)
            ->first();

            if (empty($contrato)) {
                $contrato=[
                    'numero'=>'',
                    'codigo_oc'=>''
                ];
            } 

            $value->contrato=$contrato;
            $value->proveedor=$proveedor;
        }


       return response()->json(['data'=>$data], 200); 
        
    }
    public function ordenesproveedor(Request $request)
    {
       //usar rando 10 
       $idProveedor = $request->get('idProveedor');
       $sistema = $request->get('sistema');
       $filtro = $request->get('filtro');
       $limit = $request->get('limit');
       //Orderadobe 
       $columna = $request->get('columna');
       if ($columna=='numero') {
        $columna='contratos.numero';
       }
       else{
        $columna='ordenest.'.$columna;
       }
       $order = $request->get('order');
       $filter = strtoupper($request->get('filter'));
       $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');

        // if ($columna=='contratos.numero' && $request->get('filter')=='') {
        //     $data = DB::table('ordenes')
        //     ->leftJoin('contratos', 'ordenes.codigo', '=', 'contratos.codigo_oc')
        //     ->select('*')
        //     ->orderBy($columna,$order)
        //     ->paginate($limit);
        // } else {
        //     $data = DB::table('ordenes')
        //     ->leftJoin('contratos', 'ordenes.codigo', '=', 'contratos.codigo_oc')
        //     ->select('*')
        //     ->where($columna, 'like', $ff)
        //     ->orderBy($columna,$order)
        //     ->paginate($limit);
        // }
        $data = DB::table('ordenest')
            ->leftJoin('contratos', 'ordenest.codigo', '=', 'contratos.codigo_oc')
            ->select('ordenest.*')
            ->where('ordenest.sistema_p',$sistema)
            ->where('ordenest.provedor',$idProveedor)
            ->orderBy($columna,$order)
            ->paginate($limit);

        foreach ($data as $key => $value) {
            // //rescata proveedor
            $proveedor= DB::table('proveedores')
            ->where ('codigo','=',$value->provedor)
            ->first();
            // // rescata contrato
            $contrato = Contrato::orderBy('numero','ASC')
            ->where ('codigo_oc','=',$value->codigo)
            ->first();

            if (empty($contrato)) {
                $contrato=[
                    'numero'=>'',
                    'codigo_oc'=>''
                ];
            } 

            $value->contrato=$contrato;
            $value->proveedor=$proveedor;
        }


       return response()->json(['data'=>$data], 200); 
        
    }
    public function ordenver(Request $request)
    {
    //     $codigo = $request->get('codigo');
    //     $data = DB::table('ordenes')
    //     ->where('codigo', '=', $codigo)
    //     ->first();


        $codigo = $request->get('codigo');
        $data = DB::table('ordenest')
        ->leftJoin('proveedorest', 'ordenest.provedor', '=', 'proveedorest.codigo')
        ->select('ordenest.*','proveedorest.nit')
        ->where('ordenest.codigo', '=', $codigo)
        ->first();

       return response()->json($data, 200); 
        
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
     * @param  \App\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function show(Orden $orden)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function edit(Orden $orden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orden $orden)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orden $orden)
    {
        //
    }
}
