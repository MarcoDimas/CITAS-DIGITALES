<?php

namespace Database\Seeders;
use App\Models\Municipios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Municipios();
        $role->clave = '006';
        $role->descripcion = 'APATZINGAN';
        $role->save();
        
        $role = new Municipios();
        $role->clave = '052';
        $role->descripcion = 'LÁZARO CARDENAS';
        $role->save();
        
        $role = new Municipios();
        $role->clave = '053';
        $role->descripcion = 'MORELIA';
        $role->save(); 
        
        $role = new Municipios();
        $role->clave = '066';
        $role->descripcion = 'PAZTCUARO';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '069';
        $role->descripcion = 'LA PIEDAD';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '076';
        $role->descripcion = 'SAHUAYO';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '082';
        $role->descripcion = 'TACÁMBARO';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '083';
        $role->descripcion = 'TANCÍTARO';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '102';
        $role->descripcion = 'URUAPAN';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '108';
        $role->descripcion = 'ZAMORA';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '110';
        $role->descripcion = 'ZINAPECUARO';
        $role->save(); 

        $role = new Municipios();
        $role->clave = '112';
        $role->descripcion = 'ZITÁCUARO';
        $role->save(); 
    }
}
