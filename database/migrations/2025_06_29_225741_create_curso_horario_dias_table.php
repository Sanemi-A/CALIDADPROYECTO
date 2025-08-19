<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('curso_horario_dias', function (Blueprint $table) {
            $table->id('id_horario_dia');
            $table->unsignedBigInteger('id_horario');
            $table->string('dia_semana', 10)->comment('Ej: Lunes, Martes, ...');
            $table->timestamps();

            $table->foreign('id_horario')->references('id_horario')->on('curso_horarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_horario_dias');
    }
};
