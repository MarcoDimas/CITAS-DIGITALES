<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horas extends Model
{
    use HasFactory;
    protected $table='hora';
    protected $fillable=["id_subtramite","horario_inicio","horario_fin","duracion","holgura","personas","estatus"];
}
