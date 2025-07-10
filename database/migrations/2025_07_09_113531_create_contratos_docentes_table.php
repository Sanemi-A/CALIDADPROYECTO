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
        Schema::create('contratos_docentes', function (Blueprint $table) {
            $table->id('id_contrato');
            $table->unsignedBigInteger('id_docente');
            $table->unsignedBigInteger('id_horario');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('tipo_contrato', 50)->comment('Honorarios, CAS, Nombrado, etc.');
            $table->enum('estado', ['VIGENTE', 'FINALIZADO', 'ANULADO'])->default('VIGENTE');
            $table->text('observacion')->nullable();

            $table->timestamps(); 


            // Claves foráneas
            $table->foreign('id_docente')->references('id_docente')->on('docentes')->onDelete('cascade');
            $table->foreign('id_horario')->references('id_horario')->on('curso_horarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos_docentes');
    }
};
