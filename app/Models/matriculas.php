<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';
    protected $primaryKey = 'id_matricula';
    public $timestamps = true;

    protected $fillable = [
        'id_estudiante',
        'id_horario',
        'fecha_registro',
        'responsable',

        'tipo_beca',
        'documento_beca',
        'ruta_documento',
        'descuento_beca',

        'voucher',
        'tipo_entrega',
        'codigo_operacion',
        'entidad_pago',
        'cod_pago',
        'monto',

        'observacion',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'descuento_beca' => 'integer',
        'monto' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

    public function horario()
    {
        return $this->belongsTo(CursoHorario::class, 'id_horario');
    }
}
