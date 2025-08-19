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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id('id_curso');
            $table->string('nombre_curso', 100);
            $table->unsignedBigInteger('id_programa');
            $table->string('nomenclatura', 100);

            $table->unsignedBigInteger('id_nivel');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'CULMINADO'])->default('ACTIVO');
            $table->timestamps();

            $table->foreign('id_nivel')->references('id_nivel')->on('niveles')->onDelete('cascade');
            $table->foreign('id_programa')->references('id_programa')->on('programas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
