<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subtramite;

class UpdateRequisitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subtramite::where('id', 4)->update(['requisitos' => '1.-Acta de Nacimiento. 2.-Identificación Oficial. 3.-Constancia de Servicio Social. 4.-Archivo CURP. 5.-Acta de Examen Profesional.']);
    }
}
