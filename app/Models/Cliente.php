<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'contacto',
        'ruc',
        'direccion',
        'estado',
        'notas'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'creado_en' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Tipos de cliente disponibles
     */
    public const TIPOS = [
        'Empresa',
        'Individual'
    ];

    /**
     * Estados disponibles
     */
    public const ESTADOS = [
        'activo',
        'inactivo',
        'suspendido'
    ];
}