<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_alumnos')->insert([
            [
                'nombre' => 'Estudiante vigente',
                'descripcion' => 'Alumno con matrícula activa en una carrera.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Egresado',
                'descripcion' => 'Alumno que ha finalizado satisfactoriamente su formación.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Particular',
                'descripcion' => 'Alumno que toma cursos sin pertenecer a una carrera regular.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
