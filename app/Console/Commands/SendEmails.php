<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Evento;
use App\Mail\ContratoCallReceived;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;
class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command envio de correos';

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
        echo 'Iniciando envio de mails';
        $hoy = date("Y-m-d");
        $eventos = Evento::whereDate('fecha_recordatorio','<=',date('Y-m-d'))->get();
        // $eventos = Evento::all();
        // $datos = 
        foreach ($eventos as $key => $value) {
            
            if(Carbon::parse($value->fecha_prolongacion)->format('Y-m-d') == $hoy && $value->contrato->estado == 'activo'){
                $value->contrato->estado = 'expirado';
                $value->contrato->update();
            }

            $adcount = $value->frecuencia_email_cantidad*$value->count_email;

            


            if($value->envio_email == 'si'){
            //    echo $value->fecha_evento.'\r\n';;
                if(Carbon::parse($value->fecha_evento)->format('Y-m-d') == $hoy){
                    echo $value;
                    foreach ($value->emails as $ky => $val) {
                        Mail::to($val->email)->send(new ContratoCallReceived($value));
                    }
                    $value->count_email += 1;
                    $value->update();
                }else{
                    switch ($value->frecuencia_email) {
                        case 'd':

                            if(Carbon::parse($value->fecha_recordatorio)->format('Y-m-d') == $hoy || $hoy == Carbon::parse($value->fecha_recordatorio)->addDays($adcount)->format('Y-m-d')){
                                // $infodata = ['evento'=>$value];
                                echo 'enviando d';
                                foreach ($value->emails as $ky => $val) {
                                    echo $value->id;
                                    echo $val->email;
                                    Mail::to($val->email)->send(new ContratoCallReceived($value));
                                }
                                echo 'enviado';
                                $value->count_email += 1;
                                $value->update();
                            }
                            break;
                        case 'm':
                            if(Carbon::parse($value->fecha_recordatorio)->format('Y-m-d') == $hoy || $hoy == Carbon::parse($value->fecha_recordatorio)->addMonths($adcount)->format('Y-m-d')){
                                // $infodata = ['evento'=>$value];
                                echo 'enviado m';
                                foreach ($value->emails as $ky => $val) {
                                    Mail::to($val->email)->send(new ContratoCallReceived($value));
                                }
                                echo 'enviado';
                                $value->count_email += 1;
                                $value->update();
                            }
                            break;
                        case 'y':
                            if(Carbon::parse($value->fecha_recordatorio)->format('Y-m-d') == $hoy || $hoy == Carbon::parse($value->fecha_recordatorio)->addYears($adcount)->format('Y-m-d')){
                                // $infodata = ['evento'=>$value];
                                echo 'enviando y';
                                foreach ($value->emails as $ky => $val) {
                                    Mail::to($val->email)->send(new ContratoCallReceived($value));
                                }
                                echo 'enviado';
                                $value->count_email += 1;
                                $value->update();
                            }
                            break;
                    }
                }


                
            }
            
        }
        
    }
}
