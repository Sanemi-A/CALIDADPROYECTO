<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoNota extends Model
{
    protected $table = 'estado_nota';
    protected $fillable = ['nombre', 'descripcion', 'color', 'icono', 'activo'];
    
    public function notasPedido(): HasMany
    {
        return $this->hasMany(NotaPedido::class, 'estado_id');
    }
    
    // Método para obtener estados activos
    public static function activos()
    {
        return self::where('activo', true)->get();
    }
}