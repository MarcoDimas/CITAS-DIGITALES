<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $table="tramite";
    protected $fillable=['id_dependencia','id_oficina','descripcion','domicilio','estatus']	;

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }


    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'id_dependencia');
    }
}