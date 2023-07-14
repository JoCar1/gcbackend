<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $dateinicio = $request->get('dateinicio');
        $datefin = $request->get('datefin');
        //usar rando 10 
        $limit = $request->get('limit');
        //Order
        $columna = $request->get('columna');
        $order = $request->get('order');
        $filter = $request->get('filter');
        $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');

        if(Auth::user()->rol == 'visor' ){
            switch ($columna) {
                case 'contrato':
                    $data = Evento::whereHas('contrato', function ($query) use ($columna,$ff) {
                        $query->where('nombre', 'like', $ff)
                        ->where('organizativa_unidad_id',Auth::user()->organizativa_unidad_id);
                    })
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->orderBy('contrato_id',$order)->paginate($limit);
                    break;
                
                default:
                    $data = Evento::whereHas('contrato', function ($query) use ($columna,$ff) {
                        $query->where('organizativa_unidad_id',Auth::user()->organizativa_unidad_id);
                    })
                    ->where($columna, 'like', $ff)
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->orderBy($columna,$order)->paginate($limit);
                    break;
            }
        }else{
            switch ($columna) {
                case 'contrato':
                    $data = Evento::whereHas('contrato', function ($query) use ($columna,$ff) {
                        $query->where('nombre', 'like', $ff);
                    })
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->orderBy('contrato_id',$order)->paginate($limit);
                    break;
                
                default:
                    $data = Evento::where($columna, 'like', $ff)
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->orderBy($columna,$order)->paginate($limit);
                    break;
            }    
        }

        
        foreach ($data as $key => $value) {
            $value->contrato->socio;
            $value->emails;
            $value->fecha_evento=Carbon::parse($value->fecha_evento)->format('Y-m-d');
            $value->fecha_recordatorio=Carbon::parse($value->fecha_recordatorio)->format('Y-m-d');

        }
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
            'nombre' => 'required|max:255',
            'fecha_evento' => 'required',
            'contrato_id' => 'required',
            'notificacion' => 'required',
            'envio_email' => 'required'
        ]);
        $data = $request->all();
        $evento = Evento::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'fecha_evento' => $data['fecha_evento'],
            'fecha_recordatorio' => $data['fecha_recordatorio'],
            'notificacion' => $data['notificacion'],
            'frecuencia_notificacion' => $data['frecuencia_notificacion'],
            'frecuencia_notificacion_cantidad' => $data['frecuencia_notificacion_cantidad'],
            'envio_email' => $data['envio_email'],
            'frecuencia_email' => $data['frecuencia_email'],
            'frecuencia_email_cantidad' => $data['frecuencia_email_cantidad'],
            'contrato_id' => $data['contrato_id'],
            'count_notificacion' => 1,
            'count_email' => 1
        ]);
        $correos = explode(' ', $data['correos']);
        
        foreach ($correos as $key => $value) {
            if($value != ''){
               Email::create([
                    'email' => $value,
                    'evento_id' => $evento->id
                ]); 
            }
            
        }
        
        //crear evento fechas
        $mensaje = "Registrado correctamente";
        return response()->json(['mensaje'=>$mensaje,'id'=>$evento->id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'fecha_evento' => 'required',
            'contrato_id' => 'required',
            'notificacion' => 'required',
            'envio_email' => 'required'
        ]);
        
        $data = $request->all();
        $evento = Evento::find($id);
        $evento->nombre = $data['nombre'];
        $evento->descripcion = $data['descripcion'];
        $evento->fecha_evento = $data['fecha_evento'];
        $evento->fecha_recordatorio = $data['fecha_recordatorio'];
        $evento->notificacion = $data['notificacion'];
        $evento->frecuencia_notificacion = $data['frecuencia_notificacion'];
        $evento->frecuencia_notificacion_cantidad = $data['frecuencia_notificacion_cantidad'];
        $evento->envio_email = $data['envio_email'];
        $evento->frecuencia_email = $data['frecuencia_email'];
        $evento->frecuencia_email_cantidad = $data['frecuencia_email_cantidad'];
        $evento->contrato_id = $data['contrato_id'];
        // $evento->count_notificacion = 1,
        // $evento->count_email = 1
        $evento->update();
        $correos = explode(' ', $data['correos']);

        Email::where('evento_id', $evento->id)->delete();

        foreach ($correos as $key => $value) {
            if($value != ''){
                Email::create([
                    'email' => $value,
                    'evento_id' => $evento->id
                ]); 
            }
        }
        
        //crear evento fechas
        $mensaje = "Actualizado correctamente";
        return response()->json(['mensaje'=>$mensaje,'id'=>$evento->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        $evento->delete();
        $mensaje = "Eliminado correctamente";
        return response()->json(['mensaje'=>$mensaje], 200);
    }
}
