<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Socio;
use App\Categoria;
use App\Contrato;
use App\OrganizativaUnidad;
use App\User;
use App\Notificacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class AngularController extends Controller
{
    public function socios()
    {
        $data = Socio::all()->sortBy("nombre")->values();
        return response()->json(['data'=>$data], 200); 
    }
    public function categorias()
    {
        $data = Categoria::all()->sortBy("nombre")->values();;
        return response()->json(['data'=>$data], 200); 
    }

    public function contratos()
    {
        $data = Contrato::all()->sortBy("telefono")->values();
        return response()->json(['data'=>$data], 200); 
    }
    public function uorganizativas()
    {
        $data = OrganizativaUnidad::all()->sortBy("nombre")->values();
        return response()->json(['data'=>$data], 200); 
    }


    public function usuarios()
    {
        $data = User::all()->sortBy("nombre")->values();
        return response()->json(['data'=>$data], 200); 
    }
    
    public function countnot()
    {
        $data = Notificacion::where('user_id',Auth::user()->id)->where('estado','pendiente')->get();
        // $data = Auth::user()->notificaciones;
        foreach ($data as $key => $value) {
            $value->evento->contrato->socio;
            $value->evento->emails;
            $value->evento->fecha_evento=Carbon::parse($value->evento->fecha_evento)->format('Y-m-d');
            $value->evento->fecha_recordatorio=Carbon::parse($value->evento->fecha_recordatorio)->format('Y-m-d');
            // $value['nombreev'] = $value->evento->nombre;
            // $value['fecha_eventoev'] = $value->evento->fecha_evento;
            // $value['notificacionev'] = $value->evento->notificacion;
            // $value['envio_emailev'] = $value->evento->envio_email;
            // $value['nombreev'] = $value->evento->nombre;
        }
        return response()->json(['data'=>$data], 200); 
    }
    public function cambiarestadonot()
    {
        $data = Auth::user()->notificaciones;
        foreach ($data as $key => $value) {
            $value->estado = 'aceptado';
            $value->update();
        }
        $mensaje = "Estados cambiados correctamente";
        return response()->json(['mensaje'=>$mensaje], 200); 
    }
}
