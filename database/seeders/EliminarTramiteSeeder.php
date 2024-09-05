<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tramite;
use App\Models\Subtramite;
use App\Models\Area;

class EliminarTramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $area = Area::find(1);
        if ($area) {
            $area->delete();
        }
        $tramite = Tramite::find(1);
        if ($tramite) {
            $tramite->delete();
        }
    
        $subtramite = Subtramite::find(1);
        if ($subtramite) {
            $subtramite->delete();
        }
    }
    
}
