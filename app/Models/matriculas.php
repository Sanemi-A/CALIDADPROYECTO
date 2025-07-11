<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use SoftDeletes;

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
        'ruta_voucher',

        'observacion',
        'estado',
        'validado',
        'pago_completo',
        'exonerado',
        'id_usuario_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'descuento_beca' => 'integer',
        'monto' => 'decimal:2',
        'validado' => 'boolean',
        'pago_completo' => 'boolean',
        'exonerado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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

    public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro');
    }
}
