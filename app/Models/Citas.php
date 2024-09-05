<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;
    protected $table="citas";
    protected $fillable=['folio',
    'nombre',
    'ape_paterno',
    'ape_materno',
    'rfc',
    'email',
    'telefono',
    'id_dependencia',
    'id_area',
    'id_tramite',
    'id_subtramite',
    'requisitos',
    'fecha',
    'horario',
    'estatus',
    'cencelacion',
    'motivo_cancelacion']	;
         
}
