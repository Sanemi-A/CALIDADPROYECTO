<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    public $timestamps = true;

    protected $fillable = [
        'id_persona',
        'especialidad',
        'grado_academico',
        'cv_url',
        'foto',
        'estado',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        // estado es enum, no booleano
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Encriptar automáticamente la contraseña al guardar
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relación con Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
