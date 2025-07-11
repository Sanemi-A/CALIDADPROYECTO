<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoHorario extends Model
{
    protected $table = 'curso_horarios';
    protected $primaryKey = 'id_horario';
    public $timestamps = true;

    protected $fillable = [
        'id_curso',
        'id_docente',
        'aula',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'duracion_meses',
        'modalidad',
        'precio_mensual',
        'estado',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'domingo',
    ];


    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'duracion_meses' => 'integer',
        'precio_mensual' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }
}
