<?php

namespace Database\Seeders;
use App\Models\Oficinas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OficinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Oficinas();
        $role->id_area = '15';
        $role->id_oficina = '15';
        $role->descripcion = 'DIRECCIÓN GENERAL DE GOBIERNO DIGITAL';
        $role->estatus = '1';
        $role->save();

        $role = new Oficinas();
        $role->id_area = '16';
        $role->id_oficina = '16';
        $role->descripcion = 'DIRECCIÓN GOBIERNO DIGITAL';
        $role->estatus = '1';
        $role->save();

        $role = new Oficinas();
        $role->id_area = '17';
        $role->id_oficina = '17';
        $role->descripcion = 'DIRECCIÓN DE INFRAESTRUCTURA';
        $role->estatus = '1';
        $role->save();
    }
}
