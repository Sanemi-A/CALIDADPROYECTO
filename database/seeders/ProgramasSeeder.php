<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Programa;

class ProgramasSeeder extends Seeder
{
    public function run(): void
    {
        $programas = [
            ['nombre' => 'Ordinario'],
            ['nombre' => 'Intensivo'],
            ['nombre' => 'Virtual'],
            ['nombre' => 'Semipresencial'],
            ['nombre' => 'Libre'],
        ];

        foreach ($programas as $programa) {
            Programa::create($programa);
        }
    }
}
