<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
    use HasFactory;
    protected $table='fecha';
    protected $fillable=["id_subtramite","fecha_inicio","fecha_fin","horario_inicio","horario_fin","duracion",
    "holgura","personas","estatus"];
}
