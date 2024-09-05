<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subtramite;

class AcentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subtramite::where('id', 2)->update(['descripcion' => 'Registro de Título']);

        Subtramite::where('id', 3)->update(['descripcion' => 'Solicitud de Cédula']);

        Subtramite::where('id', 4)->update(['descripcion' => 'Cédula Provisional']);
    }
}
