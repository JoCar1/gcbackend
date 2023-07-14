<?php

namespace App\Http\Controllers;

use App\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecursoController extends Controller
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

    public function marcasall()
    {
        $data = DB::table('marcas')
        ->orderby('descr')
        ->get();
       return response()->json($data, 200); 
    }

    public function departamentosall()
    {
        $data = DB::table('departamentos')
        ->orderby('nombre')
        ->get();
       return response()->json($data, 200); 
    }

    public function categoriasall()
    {
        $data = DB::table('categorias')
        ->orderby('nombre')
        ->get();
       return response()->json($data, 200); 
    }
    public function usersall()
    {
        $data = DB::table('users')
        ->orderby('nombre')
        ->get();
       return response()->json($data, 200); 
    }

    public function cuentasall()
    {
        $data = DB::table('cuentas')
        ->where('accsubtype', '=', 'N')
        ->orwhere('accsubtype', '=', 'C')
        ->orwhere('accsubtype', '=', 'X')
        ->orderby('account_key')
        ->get();
       return response()->json($data, 200); 
    }

    public function subcuentasall()
    {
        $data = DB::table('cuentas')
        ->where('accsubtype', '=', 'S')
        ->get();
       return response()->json($data, 200); 
    }
    public function proveedorestall()
    {
        $data = DB::table('proveedorest')
        ->get();
       return response()->json($data, 200); 
    }
    public function bancosall()
    {
        $data = DB::table('bancos')
        ->orderby('bankname')
        ->get();
       return response()->json($data, 200); 
    }
    public function paisesall()
    {
        $data = DB::table('paises')
        ->orderby('nombre')
        ->get();
       return response()->json($data, 200); 
    }
    public function accall()
    {
        $data = DB::table('acc')
        ->orderby('account_key')
        ->where('recon_acctype','V')
        ->get();
       return response()->json($data, 200); 
    }
    public function terminospagoall()
    {
        $data = DB::table('DUETERM')
        ->orderby('terms_code')
        ->get();
       return response()->json($data, 200); 
    }
    public function metodospagoall()
    {
        $data = DB::table('CG_REF_CODES')
        ->orderby('rv_meaning')
        ->where('rv_domain','D_PMTTYPE')
        ->get();
       return response()->json($data, 200); 
    }
    public function terminospagocoinsall()
    {
        $data = DB::table('val_term_pay')
        ->orderby('term_pay_cd')
        ->get();
       return response()->json($data, 200); 
    }
    public function proveedorestone(Request $request)
    {
        $idProveedor = $request->get('idProveedor');
        $sistema = $request->get('sistema');
        $data = DB::table('proveedorest')
        ->where('sistema',$sistema)
        ->where('codigo',$idProveedor)
        ->first();
       return response()->json($data, 200); 
    }

    // public function subcuentasall(Request $request)
    // {
    //     $cuenta = $request->get('cuenta');
    //     $data = DB::table('cuentas')
    //     ->where('accsubtype', '=', 'S')
    //     ->where('accnum', '=', $cuenta)
    //     ->get();
    //    return response()->json($data, 200); 
    // }
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
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show(Recurso $recurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit(Recurso $recurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recurso $recurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recurso $recurso)
    {
        //
    }
}
