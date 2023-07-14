<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('socio_id')->unsigned();
            $table->foreign('socio_id')
            ->references('id')->on('socios')
            ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->unsignedBigInteger('categoria_id')->unsigned();
            $table->foreign('categoria_id')
            ->references('id')->on('categorias')
            ->onDelete('cascade');
            $table->integer('contrato_id')->nullable(); //dependiente null
            $table->string('nombre');
            $table->enum('estado',['borrador',
            'negociacion',
            'pendiente',
            'activo',
            'terminado',
            'expirado',
            'revocado',
            'suspendido',
            'archivado']);
            $table->string('telefono')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_plazo_cancelacion')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_prolongacion')->nullable();
            $table->unsignedBigInteger('responsable_contrato_user_id')->unsigned();
            $table->foreign('responsable_contrato_user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->unsignedBigInteger('organizativa_unidad_id')->unsigned();
            $table->foreign('organizativa_unidad_id')
            ->references('id')->on('organizativa_unidads')
            ->onDelete('cascade');
            $table->string('contacto_adicional')->nullable();
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
        Schema::dropIfExists('contratos');
    }
}
