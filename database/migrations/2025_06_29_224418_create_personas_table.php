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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->enum('tipo_documento', ['DNI', 'RUC', 'LM', 'CE', 'PAS'])->default('DNI');
            $table->string('documento', 20)->unique();
            $table->string('nombres', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->string('celular', 20)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->enum('genero', ['M', 'F']);
            $table->tinyInteger('edad')->unsigned();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
