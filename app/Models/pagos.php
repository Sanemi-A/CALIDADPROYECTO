<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    public $timestamps = true;

    protected $fillable = [
        'id_mensualidad',
        'fecha_pago',
        'codigo_operacion',
        'entidad_pago',
        'cod_pago',
        'monto',
        'observacion',
        'estado',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function mensualidad()
    {
        return $this->belongsTo(Mensualidad::class, 'id_mensualidad');
    }
}
