<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear algunos roles de ejemplo
        Roles::create(['nombre' => 'Administrador']);
        Roles::create(['nombre' => 'Editor']);
        Roles::create(['nombre' => 'Usuario']);
    }
}
