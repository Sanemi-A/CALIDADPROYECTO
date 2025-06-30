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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id('id_matricula');

            // Clave foránea a estudiantes.id_estudiante
            $table->unsignedBigInteger('id_estudiante');
            $table->foreign('id_estudiante')->references('id_estudiante')->on('estudiantes')->onDelete('cascade');

            // Clave foránea a curso_horarios.id_horario
            $table->unsignedBigInteger('id_horario');
            $table->foreign('id_horario')->references('id_horario')->on('curso_horarios')->onDelete('cascade');

            $table->date('fecha_registro');
            $table->string('responsable', 100);

            // Beca
            $table->string('tipo_beca', 100)->nullable()->comment('Ej: BECA INTEGRAL, BECA PARCIAL');
            $table->string('documento_beca', 255)->nullable()->comment('Ej: Resolución oficial');
            $table->text('ruta_documento')->nullable()->comment('Ruta o URL del documento escaneado');
            $table->tinyInteger('descuento_beca')->nullable()->comment('Porcentaje: 50, 100');

            // Pago
            $table->string('voucher', 100)->nullable()->comment('Código del comprobante de pago');
            $table->enum('tipo_entrega', ['fisico', 'virtual'])->default('fisico');
            $table->string('codigo_operacion', 100)->nullable()->comment('Código de operación bancaria');
            $table->string('entidad_pago', 100)->nullable()->comment('Ej: BCP, Interbank');
            $table->string('cod_pago', 100)->nullable()->comment('Código interno o referencia');
            $table->decimal('monto', 10, 2)->nullable()->comment('Monto total pagado');

            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
