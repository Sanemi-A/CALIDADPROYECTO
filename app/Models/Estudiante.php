<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'id_estudiante';
    public $timestamps = true;

    protected $fillable = [
        'id_persona',
        'id_tipo_alumno',
        'id_carrera',
        'codigo_estudiante',
        'foto',
        'estado',
        'estado_financiero',
        'estado_disciplinario',
        'password', // agregado
    ];

    protected $hidden = [
        'password', // ocultar en serializaciones
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Mutator para encriptar automáticamente
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relaciones
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function tipoAlumno()
    {
        return $this->belongsTo(TipoAlumno::class, 'id_tipo_alumno');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }
}
