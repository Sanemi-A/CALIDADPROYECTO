<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota_pedido_id',
        'metodo_pago_id',
        'numero_operacion',
        'fecha',
        'monto',
        'verificado',
        'observaciones',
        'referencia',
        'user_id'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
        'verificado' => 'boolean',
        'created_at' => 'datetime'
    ];

    /**
     * Relación con la nota de pedido
     */
    public function notaPedido(): BelongsTo
    {
        return $this->belongsTo(NotaPedido::class);
    }

    /**
     * Relación con el método de pago
     */
    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }

    /**
     * Relación con el usuario que registró el pago
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Eventos del modelo para actualizar saldos
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear un pago
        static::created(function ($pago) {
            $pago->actualizarSaldoNotaPedido();
        });

        // Al actualizar un pago
        static::updated(function ($pago) {
            if ($pago->isDirty('monto')) {
                $pago->actualizarSaldoNotaPedido();
            }
        });

        // Al eliminar un pago
        static::deleted(function ($pago) {
            $pago->notaPedido->saldo_pendiente += $pago->monto;
            $pago->notaPedido->actualizarEstado();
            $pago->notaPedido->save();
        });
    }

    /**
     * Método para actualizar el saldo de la nota de pedido
     */
    public function actualizarSaldoNotaPedido(): void
    {
        $nota = $this->notaPedido;
        $totalPagado = $nota->pagos()->sum('monto');
        $nota->saldo_pendiente = $nota->importe_total - $totalPagado;
        $nota->actualizarEstado();
        $nota->save();
    }
}