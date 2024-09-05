<?php

namespace Database\Seeders;
use App\Models\Dependencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DependenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Dependencia();
        $role->id = 1;
        $role->descripcion = 'EDUCACION';
        $role->estatus = '1';
        $role->save();
    }
}
