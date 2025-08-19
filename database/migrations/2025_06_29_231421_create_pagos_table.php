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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');

            $table->unsignedBigInteger('id_mensualidad');
            $table->date('fecha_pago');

            $table->string('codigo_operacion', 100)->nullable()->comment('Código de operación bancaria');
            $table->string('entidad_pago', 100)->nullable()->comment('Entidad financiera: BCP, Interbank, etc.');
            $table->string('cod_pago', 100)->nullable()->comment('Código interno o referencia de pago');
            $table->decimal('monto', 10, 2)->nullable()->comment('Monto total pagado');
            $table->string('ruta_voucher', 255)->nullable()->comment('Ruta del voucher del pago');

            $table->unsignedBigInteger('id_usuario_registro')->nullable();
            $table->foreign('id_usuario_registro')->references('id')->on('users')->onDelete('set null');

            $table->text('observacion')->nullable();
            $table->enum('estado', ['CONFIRMADO', 'PENDIENTE', 'ANULADO'])->default('CONFIRMADO');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_mensualidad')->references('id_mensualidad')->on('mensualidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
