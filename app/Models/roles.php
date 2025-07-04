<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    // Tabla asociada (opcional si el nombre ya es "roles")
    protected $table = 'roles';

    // Campos que se pueden llenar masivamente
    protected $fillable = ['nombre'];

    // Relación: un rol puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
