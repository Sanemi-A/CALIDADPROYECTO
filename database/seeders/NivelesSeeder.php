<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nivel;

class NivelesSeeder extends Seeder
{
    public function run(): void
    {
        $niveles = [
            ['nombre' => 'Básico'],
            ['nombre' => 'Intermedio'],
            ['nombre' => 'Avanzado'],
        ];

        foreach ($niveles as $nivel) {
            Nivel::create($nivel);
        }
    }
}
