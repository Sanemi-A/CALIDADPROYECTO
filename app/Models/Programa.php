<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $table = 'programas';
    protected $primaryKey = 'id_programa';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Ejemplo de futura relación: un programa puede tener muchos cursos
    // public function cursos()
    // {
    //     return $this->hasMany(Curso::class, 'id_programa');
    // }
}
