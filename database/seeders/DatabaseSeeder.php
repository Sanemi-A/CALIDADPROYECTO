<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar a los seeders de roles y usuarios
        $this->call([
            RolesSeeder::class,
            PersonaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
