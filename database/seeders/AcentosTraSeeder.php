<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tramite;

class AcentosTraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tramite::where('id', 2)->update(['descripcion' => 'Título']);

        Tramite::where('id', 3)->update(['descripcion' => 'Cédula']);
    }
}
