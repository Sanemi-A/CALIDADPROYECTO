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
            $table->unsignedBigInteger('id_docente')->nullable();
            $table->string('aula', 100)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Días de la semana (booleanos)
            $table->boolean('lunes')->default(false);
            $table->boolean('martes')->default(false);
            $table->boolean('miercoles')->default(false);
            $table->boolean('jueves')->default(false);
            $table->boolean('viernes')->default(false);
            $table->boolean('sabado')->default(false);
            $table->boolean('domingo')->default(false);

            $table->tinyInteger('duracion_meses')->unsigned();
            $table->string('modalidad', 50);
            $table->decimal('precio_mensual', 10, 2);

            $table->unsignedInteger('cantidad_matriculado')->default(0);
            $table->unsignedInteger('cantidad_deudores')->default(0);

            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'FINALIZADO', 'ESPERA'])->default('ACTIVO');
            $table->timestamps();

            $table->foreign('id_curso')->references('id_curso')->on('cursos')->onDelete('cascade');
            $table->foreign('id_docente')->references('id_docente')->on('docentes')->onDelete('set null');
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
