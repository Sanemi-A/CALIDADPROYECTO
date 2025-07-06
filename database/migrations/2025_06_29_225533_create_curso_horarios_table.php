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
        Schema::create('curso_horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->unsignedBigInteger('id_curso');
            $table->unsignedBigInteger('id_docente');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->tinyInteger('duracion_meses')->unsigned()->comment('Ej: 2 meses = 2');
            $table->string('modalidad', 50);
            $table->decimal('precio_mensual', 10, 2)->comment('Precio por mes');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'FINALIZADO'])->default('ACTIVO');
            $table->timestamps();
            
            $table->foreign('id_curso')->references('id_curso')->on('cursos')->onDelete('cascade');
            $table->foreign('id_docente')->references('id_docente')->on('docentes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_horarios');
    }
};
