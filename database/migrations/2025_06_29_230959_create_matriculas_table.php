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

            // Relaciones
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_horario');

            // Datos generales
            $table->date('fecha_registro')->comment('Fecha efectiva de la matrícula');
            $table->string('responsable', 100);

            // Beca
            $table->string('tipo_beca', 100)->nullable()->comment('Ej: BECA INTEGRAL, BECA PARCIAL');
            $table->string('documento_beca', 255)->nullable()->comment('Ej: Resolución oficial');
            $table->text('ruta_documento')->nullable()->comment('Ruta o URL del documento escaneado');
            $table->tinyInteger('descuento_beca')->nullable()->comment('Porcentaje: 50, 100');

            // Pago de matrícula
            $table->string('voucher', 100)->nullable()->comment('Código del comprobante de pago');
            $table->enum('tipo_entrega', ['fisico', 'virtual'])->default('fisico');
            $table->string('codigo_operacion', 100)->nullable()->comment('Código de operación bancaria');
            $table->string('entidad_pago', 100)->nullable()->comment('Ej: BCP, Interbank');
            $table->string('cod_pago', 100)->nullable()->comment('Código interno o referencia');
            $table->decimal('monto', 10, 2)->nullable()->comment('Monto total pagado');
            $table->string('ruta_voucher', 255)->nullable()->comment('Ruta o URL del archivo o imagen del voucher');

            // Estado y control
            $table->text('observacion')->nullable();
            $table->enum('estado', ['VIGENTE', 'CANCELADA', 'RETIRADA', 'FINALIZADA'])->default('VIGENTE');
            $table->boolean('validado')->default(false);
            $table->boolean('pago_completo')->default(false)->comment('Pagó la matrícula y todas las cuotas');
            $table->boolean('exonerado')->default(false)->comment('No paga nada por beca 100%');

            $table->unsignedBigInteger('id_usuario_registro')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Relaciones
            $table->foreign('id_estudiante')->references('id_estudiante')->on('estudiantes')->onDelete('cascade');
            $table->foreign('id_horario')->references('id_horario')->on('curso_horarios')->onDelete('cascade');
            $table->foreign('id_usuario_registro')->references('id')->on('users')->onDelete('set null');

            // Índices
            $table->index(['id_estudiante', 'id_horario', 'fecha_registro', 'estado']);
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
