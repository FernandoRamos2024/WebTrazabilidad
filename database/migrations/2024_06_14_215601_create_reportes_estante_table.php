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
        Schema::create('reportes_estante', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_proyecto', 30);
            $table->string('codigo_partida', 30);
            $table->date('fecha');
            $table->time('hora');
            $table->enum('accion', ['entrada', 'salida']);
            $table->decimal('tiempo_total', 15, 2)->nullable();
            $table->enum('estatus', ['conforme', 'no conforme', 'revisar'])->default('conforme');
            $table->string('revision', 250)->nullable();
            $table->bigInteger('id_estante')->unsigned();
            $table->foreign('id_estante')->references('id')->on('estantes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_estante');
    }
};
