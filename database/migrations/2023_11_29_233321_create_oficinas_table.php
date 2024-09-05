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
        Schema::create('oficina', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 120);
            $table->unsignedBigInteger("id_dependencia");
            $table->foreign('id_dependencia')->references('id')->on('dependencia')->onDelete('cascade'); 
            $table->boolean('estatus');        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
