<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    // (Opcional, si la tabla se llama "roles" no necesitas esta línea)
    protected $table = 'roles';

    // Campos que se pueden llenar masivamente
    protected $fillable = ['nombre'];

    // Relación: un rol puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'rol_id', 'id');
    }
}
