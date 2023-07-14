<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Archivo;
use App\Evento;
use App\Email;
use App\User;
use App\Socio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\Recordatorio;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //usar rando 10 
        $dateinicio = $request->get('dateinicio');
        $datefin = $request->get('datefin');

        $limit = $request->get('limit');
        //Order
        $columna = $request->get('columna');
        $order = $request->get('order');
        $filter =$request->get('filter');
        $ff = $request->get('ff', $filter==''?'%%':'%'. $filter.'%');

        if(Auth::user()->rol == 'visor' ){
            switch ($columna) {
                case 'socio':
                    $data = Contrato::whereHas('socio', function ($query) use ($columna,$ff) {
                        $query->whereraw('upper(socios.nombre) like  \''.strtoupper($ff).'\'');
                    })
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->where('organizativa_unidad_id',Auth::user()->organizativa_unidad_id)
                    ->orderBy('socio_id',$order)->paginate($limit);
                    break;
                case 'categoria':
                    $data = Contrato::whereHas('categoria', function ($query) use ($columna,$ff) {
                        $query->whereraw('upper(categorias.nombre) like  \''.strtoupper($ff).'\'');
                    })
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->where('organizativa_unidad_id',Auth::user()->organizativa_unidad_id)
                    ->orderBy('categoria_id',$order)->paginate($limit);
                    break;
                default:
                    $data = Contrato::where($columna, 'like', $ff)
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->where('organizativa_unidad_id',Auth::user()->organizativa_unidad_id)
                    ->orderBy($columna,$order)->paginate($limit);
                    break;
            }
        }else{
            switch ($columna) {
                case 'socio':
                    $data = Contrato::whereHas('socio', function ($query) use ($columna,$ff) {
                        $query->whereraw('upper(socios.nombre) like  \''.strtoupper($ff).'\'');
                    })
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->orderBy('socio_id',$order)->paginate($limit);
                    break;
                case 'categoria':
                    $data = Contrato::whereHas('categoria', function ($query) use ($columna,$ff) {
                        $query->whereraw('upper(categorias.nombre) like  \''.strtoupper($ff).'\'');
                    })
                    ->where(function($querydata) use($dateinicio,$datefin){
                        if($dateinicio && $datefin){
                            $querydata->whereBetween('created_at',[$dateinicio,$datefin]);
                        }
                    })
                    ->orderBy('categoria_id',$order)->paginate($limit);
                    break;
                default:
                    $data = Contrato::where($columna, 'like', $ff)
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
            $value->socio;
            $value->categoria;
            $value->user;
            $value['responsable'] = User::find($value->responsable_contrato_user_id);
            $value->organizativaunidad;
            $value->fecha_inicio=Carbon::parse($value->fecha_inicio)->format('Y-m-d');
            // $value->fecha_plazo_cancelacion=Carbon::parse($value->fecha_plazo_cancelacion)->format('Y-m-d');
            // $value->fecha_fin=Carbon::parse($value->fecha_fin)->format('Y-m-d');
            // $value->fecha_prolongacion=$value?Carbon::parse($value->fecha_prolongacion)->format('Y-m-d'):'';
            if ($value->fecha_fin===null) {
                $value->fecha_fin ='';
            } else {
                $value->fecha_fin=  $value->fecha_fin?Carbon::parse( $value->fecha_fin)->format('Y-m-d'):null;
            }
            if ($value->fecha_plazo_cancelacion===null) {
                $value->fecha_plazo_cancelacion ='';
            } else {
                $value->fecha_plazo_cancelacion= $value->fecha_plazo_cancelacion?Carbon::parse($value->fecha_plazo_cancelacion)->format('Y-m-d'):null;
            }
            if ($value->fecha_prolongacion===null) {
                $value->fecha_prolongacion= '';
            } else {
                $value->fecha_prolongacion =$value->fecha_prolongacion?Carbon::parse($value->fecha_prolongacion)->format('Y-m-d'):null;
            }
            foreach ($value->archivos as $ky => $val) {
                $val->url = asset($val->url);
            }
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

    public function contratover(Request $request)
    {
        $sistema = $request->get('sistema');
        $codigo = $request->get('codigo');
        $data = DB::table('contratos')
        ->where('sistema', '=', $sistema)
        ->where('codigo_oc', '=', $codigo)
        ->first();

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
        $contrato = new Contrato($request->all());
        $contrato->save();
        // DESCOMENTAR PARA CONTRATOS
        $recordatorio = new Recordatorio();
        $recordatorio->asunto='Fecha incio';
        $recordatorio->fecha=$contrato->fecha_inicio;
        $recordatorio->recordatorio=5;
        $recordatorio->codigo_oc=$contrato->codigo_oc;
        $recordatorio->save();

        $recordatorio2 = new Recordatorio();
        $recordatorio2->asunto='Fecha fin';
        $recordatorio2->fecha=$contrato->fecha_fin;
        $recordatorio2->recordatorio=5;
        $recordatorio2->codigo_oc=$contrato->codigo_oc;
        $recordatorio2->save();

        return response()->json([
            'mensaje' => 'Contrato guardado exitosamente',
            'contrato' => $contrato
        ], 201);

        // $mensaje = "Registrado correctamente";
        // return response()->json(['mensaje'=>$mensaje,'id'=>$contrato], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrato $contrato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        $contrato->update($request->all());

        $recordatorio = new Recordatorio();
        $recordatorio->asunto='Fecha incio';
        $recordatorio->fecha=$contrato->fecha_inicio;
        $recordatorio->recordatorio=5;
        $recordatorio->codigo_oc=$contrato->codigo_oc;
        $recordatorio->save();
        
        $recordatorio2 = new Recordatorio();
        $recordatorio2->asunto='Fecha fin';
        $recordatorio2->fecha=$contrato->fecha_fin;
        $recordatorio2->recordatorio=5;
        $recordatorio2->codigo_oc=$contrato->codigo_oc;
        $recordatorio2->save();

        return response()->json(['mensaje' => 'Contrato actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrato $contrato)
    {
        //
    }
}
