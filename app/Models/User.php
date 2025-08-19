<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'id_persona',
        'email',
        'foto',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'rol_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }


    public function getNombreCompletoAttribute()
    {
        if ($this->persona) {
            return "{$this->persona->nombres} {$this->persona->apellido_paterno} {$this->persona->apellido_materno}";
        }
        return '';
    }
    public function getNombresAttribute()
    {
        return $this->persona->nombres ?? '';
    }

    public function getApellidoPaternoAttribute()
    {
        return $this->persona->apellido_paterno ?? '';
    }

    public function getApellidoMaternoAttribute()
    {
        return $this->persona->apellido_materno ?? '';
    }
}
