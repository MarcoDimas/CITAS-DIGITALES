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
        Schema::create('hora', function (Blueprint $table) {
            $table->id();     
            $table->unsignedBigInteger("id_subtramite");
            $table->foreign('id_subtramite')->references('id')->on('subtramite')->onDelete('cascade');                     
            $table->time('horario_inicio');
            $table->time('horario_fin');
            $table->string('duracion');
            $table->string('holgura')->nullable();
            $table->string('personas')->nullable();
            $table->boolean('estatus'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hora');
    }
};
