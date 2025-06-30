<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoHorarioDia extends Model
{
    protected $table = 'curso_horario_dias';
    protected $primaryKey = 'id_horario_dia';
    public $timestamps = true;

    protected $fillable = [
        'id_horario',
        'dia_semana',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function horario()
    {
        return $this->belongsTo(CursoHorario::class, 'id_horario');
    }
}
