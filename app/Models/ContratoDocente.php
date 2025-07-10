<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoDocente extends Model
{
    use HasFactory;

    protected $table = 'contratos_docentes';
    protected $primaryKey = 'id_contrato';

    protected $fillable = [
        'id_docente',
        'id_horario',
        'fecha_inicio',
        'fecha_fin',
        'tipo_contrato',
        'estado',
        'observacion',
    ];

    public $timestamps = true;

    // Relaciones

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    public function horario()
    {
        return $this->belongsTo(CursoHorario::class, 'id_horario', 'id_horario');
    }
}
