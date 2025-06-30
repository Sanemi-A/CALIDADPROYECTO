<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    public $timestamps = true;

    protected $fillable = [
        'tipo_documento',
        'documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'celular',
        'correo',
        'direccion',
        'genero',
        'edad',
    ];

    protected $casts = [
        'edad' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
