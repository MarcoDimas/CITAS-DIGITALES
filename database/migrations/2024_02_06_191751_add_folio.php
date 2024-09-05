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
        Schema::table('cita', function (Blueprint $table) {
            $table->string('folio', 150)->nullable();
            // Tipo VARCHAR de longitud 10
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cita', function (Blueprint $table) {
            $table->dropColumn('folio');
        });
    }
};
