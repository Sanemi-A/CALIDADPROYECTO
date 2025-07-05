<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAlumno extends Model
{
    use HasFactory;

    // Nombre de la tabla (por si no sigue la convención plural)
    protected $table = 'tipo_alumnos';

    // Clave primaria
    protected $primaryKey = 'id_tipo_alumno';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    // Relaciones
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_tipo_alumno');
    }
}
