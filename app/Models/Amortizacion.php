<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Amortizacion extends Model
{
    protected $table = 'amortizaciones';
    
    protected $fillable = [
        'nota_pedido_id',
        'pago_id',
        'nota_relacionada_id',
        'monto',
        'fecha',
        'tipo',
        'observaciones',
        'user_id'
    ];
    
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
        'created_at' => 'datetime'
    ];
    
    const TIPOS = [
        'amortizacion' => 'Amortización',
        'descuento' => 'Descuento',
        'cancelacion' => 'Cancelación'
    ];
    
    public function notaPedido(): BelongsTo
    {
        return $this->belongsTo(NotaPedido::class);
    }
    
    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class);
    }
    
    public function notaRelacionada(): BelongsTo
    {
        return $this->belongsTo(NotaPedido::class, 'nota_relacionada_id');
    }
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($amortizacion) {
            $amortizacion->actualizarSaldoNotaPedido();
        });
        
        static::updated(function ($amortizacion) {
            if ($amortizacion->isDirty('monto')) {
                $amortizacion->actualizarSaldoNotaPedido();
            }
        });
        
        static::deleted(function ($amortizacion) {
            $nota = $amortizacion->notaPedido;
            $nota->saldo_pendiente += $amortizacion->monto;
            $nota->actualizarEstado();
            $nota->save();
        });
    }
    
    public function actualizarSaldoNotaPedido(): void
    {
        $nota = $this->notaPedido;
        $totalAmortizado = $nota->amortizaciones()->where('tipo', 'amortizacion')->sum('monto');
        $totalDescuentos = $nota->amortizaciones()->where('tipo', 'descuento')->sum('monto');
        
        $nota->saldo_pendiente = $nota->importe_total - $totalAmortizado + $totalDescuentos;
        $nota->actualizarEstado();
        $nota->save();
    }
}