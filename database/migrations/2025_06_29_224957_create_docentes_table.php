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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id('id_docente');
            $table->unsignedBigInteger('id_persona');
            $table->string('especialidad', 100);
            $table->string('grado_academico', 100);
            $table->text('cv_url')->nullable();
            $table->string('foto')->nullable();
            $table->string('password')->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'INHABILITADO', 'SUSPENDIDO', 'RETIRADO'])->default('ACTIVO');
            $table->timestamps();

            $table->foreign('id_persona')
                ->references('id_persona')
                ->on('personas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
