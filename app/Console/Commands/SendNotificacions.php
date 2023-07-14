<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use App\Evento;
use App\Notificacion;

class SendNotificacions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendnotificacions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command envio de notificaciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'Enviando notificaciones';
        $hoy = date("Y-m-d");
        $eventos = Evento::whereDate('fecha_recordatorio','<=',date('Y-m-d'))->get();
        // $eventos = Evento::all();
        
        foreach ($eventos as $key => $value) {
            $adcount = $value->frecuencia_notificacion_cantidad*$value->count_notificacion;
            if($value->notificacion == 'si'){

                if(Carbon::parse($value->fecha_evento)->format('Y-m-d') == $hoy){
                    Notificacion::create([
                        'user_id' => $value->contrato->user_id,
                        'evento_id' => $value->id,
                        'estado' => 'pendiente' 
                    ]);
                    if($value->contrato->user_id != $value->contrato->responsable_contrato_user_id){
                        Notificacion::create([
                            'user_id' => $value->contrato->responsable_contrato_user_id,
                            'evento_id' => $value->id,
                            'estado' => 'pendiente' 
                        ]);    
                    }
                    $value->count_notificacion += 1;
                    $value->update();
                }else{
                    switch ($value->frecuencia_notificacion) {
                        case 'd':
                        
                            if(Carbon::parse($value->fecha_recordatorio)->format('Y-m-d') == $hoy || $hoy == Carbon::parse($value->fecha_recordatorio)->addDays($adcount)->format('Y-m-d')){
                                // $infodata = ['evento'=>$value];
                                Notificacion::create([
                                    'user_id' => $value->contrato->user_id,
                                    'evento_id' => $value->id,
                                    'estado' => 'pendiente' 
                                ]);
                                if($value->contrato->user_id != $value->contrato->responsable_contrato_user_id){
                                    Notificacion::create([
                                        'user_id' => $value->contrato->responsable_contrato_user_id,
                                        'evento_id' => $value->id,
                                        'estado' => 'pendiente' 
                                    ]);    
                                }
                                $value->count_notificacion += 1;
                                $value->update();
                            }
                            break;
                        case 'm':
                            if(Carbon::parse($value->fecha_recordatorio)->format('Y-m-d') == $hoy || $hoy == Carbon::parse($value->fecha_recordatorio)->addMonths($adcount)->format('Y-m-d')){
                                // $infodata = ['evento'=>$value];
                                Notificacion::create([
                                    'user_id' => $value->contrato->user_id,
                                    'evento_id' => $value->id,
                                    'estado' => 'pendiente' 
                                ]);
                                if($value->contrato->user_id != $value->contrato->responsable_contrato_user_id){
                                    Notificacion::create([
                                        'user_id' => $value->contrato->responsable_contrato_user_id,
                                        'evento_id' => $value->id,
                                        'estado' => 'pendiente' 
                                    ]);    
                                }
                                $value->count_notificacion += 1;
                                $value->update();
                            }
                            break;
                        case 'y':
                            if(Carbon::parse($value->fecha_recordatorio)->format('Y-m-d') == $hoy || $hoy == Carbon::parse($value->fecha_recordatorio)->addYears($adcount)->format('Y-m-d')){
                                // $infodata = ['evento'=>$value];
                                Notificacion::create([
                                    'user_id' => $value->contrato->user_id,
                                    'evento_id' => $value->id,
                                    'estado' => 'pendiente' 
                                ]);
                                if($value->contrato->user_id != $value->contrato->responsable_contrato_user_id){
                                    Notificacion::create([
                                        'user_id' => $value->contrato->responsable_contrato_user_id,
                                        'evento_id' => $value->id,
                                        'estado' => 'pendiente' 
                                    ]);    
                                }
                                
                                $value->count_notificacion += 1;
                                $value->update();
                            }
                            break;
                    }    

                }
                
            }
            
        }
    }
}
