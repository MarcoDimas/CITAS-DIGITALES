<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table='area';
    protected $fillable=['id','id_dependencia','descripcion','estatus'];

    
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'id_dependencia');
    }
}
