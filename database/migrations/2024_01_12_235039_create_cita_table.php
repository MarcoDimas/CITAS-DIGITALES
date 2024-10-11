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
        Schema::create('cita', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_tramite");
            $table->foreign('id_tramite')->references('id')->on('tramite'); 
            $table->unsignedBigInteger("id_subtramite");
            $table->foreign('id_subtramite')->references('id')->on('subtramite');  
            $table->string('nombre');
            $table->string('ape_paterno');
            $table->string('ape_materno');
            $table->string('rfc');
            $table->string('email');
            $table->string('telefono');           
            $table->date('fecha');
            $table->time('horario');
            $table->boolean('cancelada')->default(false);
            $table->string('folio', 150)->nullable();
            $table->boolean('estatus');
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};
