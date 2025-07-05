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
            $table->unsignedBigInteger('id_tipo_alumno');
            $table->unsignedBigInteger('id_carrera')->nullable();
            $table->string('codigo_estudiante', 50)->nullable();
            $table->string('foto', 255)->nullable()->comment('Ruta de la foto del estudiante');
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->enum('estado_financiero', ['REGULAR', 'DEUDOR'])->default('REGULAR');
            $table->enum('estado_disciplinario', ['SIN_SANCION', 'SANCIONADO'])->default('SIN_SANCION');
            $table->timestamps();

            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_tipo_alumno')->references('id_tipo_alumno')->on('tipo_alumnos');
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
