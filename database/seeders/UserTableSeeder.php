<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SUPER ADMINISTRADOR',
            'email' => 'superAdmi@gmail.com',
            'password' => Hash::make('super22'),
            'estatus' => '1', 
            'id_roles' => 1,
            'id_dependencia' => 1,
        ]);

        User::create([
            'name' => 'ADMININSTRADOR',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin22'),
            'estatus' => '1',
            'id_roles' => 2,
            'id_dependencia' => 1, 
        ]);

        User::create([
            'name' => 'CITAS',
            'email' => 'citas@gmail.com',
            'password' => Hash::make('cita22'),
            'estatus' => '1', 
            'id_roles' => 3, 
            'id_dependencia' => 1, 
        ]);
       
    }
}
