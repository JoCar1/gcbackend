<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre'); 
            $table->text('descripcion')->nullable(); 
            $table->date('fecha_evento'); 
            $table->date('fecha_recordatorio')->nullable();
            $table->enum('notificacion',['si','no']); 
            $table->integer('count_notificacion')->nullable();
            $table->enum('frecuencia_notificacion',['d','m','y'])->nullable();
            $table->integer('frecuencia_notificacion_cantidad')->nullable();
            $table->enum('envio_email',['si','no']); 
            $table->integer('count_email')->nullable();
            $table->enum('frecuencia_email',['d','m','y'])->nullable();
            $table->integer('frecuencia_email_cantidad')->nullable();
            $table->unsignedBigInteger('contrato_id')->unsigned();
            $table->foreign('contrato_id')
            ->references('id')->on('contratos')
            ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
