<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            [
                'tipo_documento' => 'DNI',
                'documento' => '12345678',
                'nombres' => 'MICHAEL DEYVIS',
                'apellido_paterno' => 'MAMANI',
                'apellido_materno' => 'CHOQQUE',
                'celular' => '987654321',
                'correo' => 'dmamanic@unamad.edu.pe',
                'direccion' => 'Av. Siempre Viva 123',
                'genero' => 'M',
                'edad' => 30,
            ],
            [
                'tipo_documento' => 'DNI',
                'documento' => '87654321',
                'nombres' => 'ANA',
                'apellido_paterno' => 'LOPEZ',
                'apellido_materno' => 'GOMEZ',
                'celular' => '912345678',
                'correo' => 'ana@example.com',
                'direccion' => 'Jr. Las Flores 456',
                'genero' => 'F',
                'edad' => 28,
            ]
        ];

        foreach ($personas as $p) {
            Persona::create($p);
        }
    }
}
