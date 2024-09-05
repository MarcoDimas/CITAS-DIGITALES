<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtramite extends Model
{
    use HasFactory;

    protected $table="subtramite";
    protected $fillable=['id_tramite','descripcion','requisitos','estatus']	;

    public function tramite()
    {
        return $this->belongsTo(Tramite::class, 'id_tramite');
    }
}
