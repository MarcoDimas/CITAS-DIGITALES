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
        Schema::create('tramite', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger("id_dependencia");
            $table->foreign('id_dependencia')->references('id')->on('dependencia')->onDelete('cascade');               
            $table->unsignedBigInteger("id_area");
            $table->foreign('id_area')->references('id')->on('area')->onDelete('cascade'); 
            $table->string('descripcion');
            $table->string('domicilio');
            $table->boolean('estatus');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite');
    }
};
