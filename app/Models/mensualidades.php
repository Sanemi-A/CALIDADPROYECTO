<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    protected $table = 'mensualidades';
    protected $primaryKey = 'id_mensualidad';
    public $timestamps = true;

    protected $fillable = [
        'id_matricula',
        'numero_cuota',
        'fecha_vencimiento',
        'monto',
        'estado',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
        'numero_cuota' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'id_matricula');
    }
}
