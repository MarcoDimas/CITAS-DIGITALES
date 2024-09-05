<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    protected $table='users';
    protected $fillable=["name","email","password","id_dependencia","estatus", "id_roles"];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'id_roles');
    }
}
