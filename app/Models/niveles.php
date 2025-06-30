<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';
    protected $primaryKey = 'id_nivel';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Si más adelante se relaciona con cursos u otros modelos:
    // public function cursos()
    // {
    //     return $this->hasMany(Curso::class, 'id_nivel');
    // }
}
