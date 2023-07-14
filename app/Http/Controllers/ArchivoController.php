<?php

namespace App\Http\Controllers;

use App\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ArchivoController extends Controller
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
            'file' => 'required|file'
        ]);
        if(!$request->hasFile('file')) {
            $mensaje = "Archivo no encontrado";
        }else{
            $file = $request->file('file'); 
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = $request->contrato_id."-".$file->getClientOriginalName()."-".date('his')."-".rand(0,10).rand(0,10).".".$extension;
            $path = 'archivos/';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if($file->move($path, $fileName)){
                Archivo::create([
                    'nombre' => $file->getClientOriginalName(),
                    'url' => 'archivos/'.$fileName,
                    'contrato_id' => $request->contrato_id,
                    'sistema' => $request->sistema,
                    'sistema_p' => $request->sistema_p,
                    'proveedor_id' => $request->proveedor_id
                ]);  
            }
            $mensaje = "Registrado correctamente";    
        }
        echo $mensaje;
        return response()->json(['mensaje'=>$mensaje], 200);
    }

    public function archivos(Request $request)
    {
        
        $codigo = $request->get('codigo');
        $data = DB::table('archivos')
        ->where('contrato_id', '=', $codigo)
        ->orderby('contrato_id','ASC')
        ->get();

        foreach ($data as $ky => $val) {
            $val->url = asset($val->url);
        }

        return response()->json($data, 200); 
        
    }
    public function archivosFile(Request $request)
    {
        
        $proveedor_id = $request->get('proveedor_id');
        $sistema = $request->get('sistema');
        $data = DB::table('archivos')
        ->where('sistema', '=', $sistema)
        ->where('proveedor_id', '=', $proveedor_id)
        ->get();

        foreach ($data as $ky => $val) {
            $val->url = asset($val->url);
        }

        return response()->json($data, 200); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Archivo $archivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archivo $archivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archivo $archivo)
    {
        $archivo->delete();
        $mensaje = "Eliminado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);

    }
}
