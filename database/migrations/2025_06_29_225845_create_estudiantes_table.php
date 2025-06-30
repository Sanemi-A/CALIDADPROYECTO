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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('id_estudiante');
            $table->unsignedBigInteger('id_persona');
            $table->string('tipo_alumno', 50)->comment('Estudiante vigente, Egresado, Particular.');
            $table->unsignedBigInteger('id_carrera')->nullable()->comment('Solo si es estudiante vigente');
            $table->string('codigo_estudiante', 50)->nullable()->comment('Solo si es estudiante vigente');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'EGRESADO'])->default('ACTIVO');
            $table->timestamps(); 

            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_carrera')->references('id_carrera')->on('carreras')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
