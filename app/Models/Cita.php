<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table="cita";
    protected $fillable=['id_tramite',    
    'id_subtramite',
    'nombre',
    'ape_paterno',
    'ape_materno',
    'rfc',
    'email',
    'telefono',
    'fecha',
    'horario',
    'estatus',
    'folio']	;


      public function tramite()
    {
        return $this->belongsTo(Tramite::class, 'id_tramite');
    }
    public function subtramite()
    {
        return $this->belongsTo(Subtramite::class, 'id_subtramite');
    }
}
