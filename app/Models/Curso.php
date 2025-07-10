<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id_curso';
    public $timestamps = true;

    protected $fillable = [
        'nombre_curso',
        'id_programa',
        'nomenclatura',
        'id_nivel',
        'estado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel');
    }
}
