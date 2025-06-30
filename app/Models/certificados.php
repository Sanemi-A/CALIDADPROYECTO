<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'certificados';
    protected $primaryKey = 'id_certificado';
    public $timestamps = true;

    protected $fillable = [
        'id_matricula',
        'codigo_certificado',
        'fecha_emision',
        'url_archivo',
        'estado',
        'observacion',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'id_matricula');
    }
}
