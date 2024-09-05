<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;
    protected $table='dependencia';
    protected $fillable=["id","descripcion","estatus"];

    public function users()
{
    return $this->hasMany(User::class, 'id_dependencia');
}
public function areas()
{
    return $this->hasMany(Area::class);
}

}
