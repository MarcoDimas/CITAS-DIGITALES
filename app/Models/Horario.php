<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    
    protected $table='horario_desglose';
    protected $fillable=["id_fecha","horario_inicio","horario_fin","duracion","estatus"];
}
