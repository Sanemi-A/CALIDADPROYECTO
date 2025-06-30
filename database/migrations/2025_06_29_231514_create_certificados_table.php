<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id('id_certificado');
            $table->unsignedBigInteger('id_matricula');
            $table->string('codigo_certificado', 50)->unique()->comment('Ej: CERT-2025-0001');
            $table->date('fecha_emision');
            $table->text('url_archivo')->comment('Ruta al archivo generado o subido');
            $table->enum('estado', ['GENERADO', 'ENTREGADO', 'ANULADO'])->default('GENERADO');
            $table->text('observacion')->nullable();
            $table->timestamps();
            
            $table->foreign('id_matricula')->references('id_matricula')->on('matriculas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
