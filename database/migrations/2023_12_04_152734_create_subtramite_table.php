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
        Schema::create('subtramite', function (Blueprint $table) {
            $table->id();     
            $table->unsignedBigInteger("id_tramite");
            $table->foreign('id_tramite')->references('id')->on('tramite')->onDelete('cascade');                     
            $table->string('descripcion');
            $table->string('requisitos');
            $table->boolean('estatus'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtramite');
    }
};
