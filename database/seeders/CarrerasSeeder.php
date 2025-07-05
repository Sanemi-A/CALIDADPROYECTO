<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('carreras')->insert([
            [
                'nombre' => 'Ingeniería de Sistemas e Informática',
                'prefijo' => 'ISI',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Ingeniería Agroindustrial',
                'prefijo' => 'IAI',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Ingeniería Forestal y Medio Ambiente',
                'prefijo' => 'IFMA',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Enfermería',
                'prefijo' => 'ENF',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Medicina Veterinaria - Zootecnia',
                'prefijo' => 'MVZ',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Administración y Negocios Internacionales',
                'prefijo' => 'ANI',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Contabilidad y Finanzas',
                'prefijo' => 'CFI',
                'created_at' => $now,
            ],
            [
                'nombre' => 'Derecho y Ciencias Políticas',
                'prefijo' => 'DCP',
                'created_at' => $now,
            ],
        ]);
    }
}
