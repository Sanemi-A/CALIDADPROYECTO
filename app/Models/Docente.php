<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'estado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
