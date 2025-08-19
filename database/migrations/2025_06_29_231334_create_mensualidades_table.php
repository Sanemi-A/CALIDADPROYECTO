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
        Schema::create('mensualidades', function (Blueprint $table) {
            $table->id('id_mensualidad');

            $table->unsignedBigInteger('id_matricula');
            $table->tinyInteger('numero_cuota')->unsigned()->comment('1, 2, 3, ...');

            $table->date('fecha_vencimiento');
            $table->decimal('monto', 10, 2);
            $table->enum('estado', ['PENDIENTE', 'PAGADO', 'VENCIDO'])->default('PENDIENTE');

            $table->timestamps();
            $table->softDeletes();

            // Restricciones
            $table->foreign('id_matricula')->references('id_matricula')->on('matriculas')->onDelete('cascade');
            $table->unique(['id_matricula', 'numero_cuota']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensualidades');
    }
};
