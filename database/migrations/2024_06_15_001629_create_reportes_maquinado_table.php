<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reportes_maquinado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_proyecto', 30);
            $table->string('codigo_partida', 30);
            $table->date('fecha');
            $table->time('hora');
            $table->enum('turno', ['primero', 'segundo']);
            $table->enum('accion', ['entrada', 'turno terminado', 'pieza terminada']);
            $table->enum('estatus', ['proceso', 'finalizado', 'revisar'])->default('proceso');
            $table->decimal('tiempo_total', 15, 2)->nullable();
            $table->string('revision', 250)->nullable();
            $table->bigInteger('id_area')->unsigned();
            $table->bigInteger('id_maquina')->unsigned();
            $table->bigInteger('id_operador')->unsigned();

            $table->foreign('id_area')->references('id')->on('areas');
            $table->foreign('id_maquina')->references('id')->on('maquinas');
            $table->foreign('id_operador')->references('id')->on('operadores');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_maquinado');
    }
};