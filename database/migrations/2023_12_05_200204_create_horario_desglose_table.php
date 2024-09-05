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
        Schema::create('horario_desglose', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger("id_fecha");
            $table->foreign('id_fecha')->references('id')->on('fecha')->onDelete('cascade');   
            $table->time('horario_inicio');
            $table->time('horario_fin');
            $table->string('duracion');          
            $table->boolean('estatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_desglose');
    }
};
