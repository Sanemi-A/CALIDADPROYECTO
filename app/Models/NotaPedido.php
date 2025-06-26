<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotaPedido extends Model
{
    protected $table = 'notas_pedido';
    
    protected $fillable = [
        'numero', // Ahora se espera que el usuario ingrese este valor
        'cliente_id', 
        'responsable_id', 
        'fecha',
        'guia', 
        'importe_total', 
        'estado_id', 
        'saldo_pendiente',
        'observaciones', 
        'user_id'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'importe_total' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
    
    /**
     * Relación con el responsable
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Responsable::class);
    }
    
    /**
     * Relación con el estado
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoNota::class, 'estado_id');
    }
    
    /**
     * Relación con el usuario creador
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Relación con los pagos asociados
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
    
    /**
     * Validación del número único antes de crear
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($nota) {
            // Verificar que el número sea único
            if (self::where('numero', $nota->numero)->exists()) {
                throw new \Exception('El número de pedido ya existe');
            }
        });
    }
    
    /**
     * Actualiza el estado basado en el saldo pendiente
     */
    public function actualizarEstado(): void
    {
        if ($this->saldo_pendiente <= 0) {
            $this->estado_id = EstadoNota::where('nombre', 'Completado')->first()->id;
        } elseif ($this->saldo_pendiente < $this->importe_total) {
            $this->estado_id = EstadoNota::where('nombre', 'Parcial')->first()->id;
        } else {
            $this->estado_id = EstadoNota::where('nombre', 'Pendiente')->first()->id;
        }
        
        $this->save();
    }
    
    /**
     * Calcula el saldo pendiente basado en los pagos
     */
    public function calcularSaldoPendiente(): void
    {
        $totalPagado = $this->pagos()->sum('monto');
        $this->saldo_pendiente = max(0, $this->importe_total - $totalPagado);
        $this->save();
    }
    
    /**
     * Verifica si el pedido está completamente pagado
     */
    public function estaPagado(): bool
    {
        return $this->saldo_pendiente <= 0;
    }
    
    /**
     * Buscar por número de pedido
     */
    public static function buscarPorNumero($numero)
    {
        return self::where('numero', $numero)->first();
    }
}