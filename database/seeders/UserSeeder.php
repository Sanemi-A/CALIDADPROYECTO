<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Obtener las personas por su documento
        $persona1 = Persona::where('documento', '12345678')->first();
        $persona2 = Persona::where('documento', '87654321')->first();

        // Obtener roles
        $rolProgramador = Roles::where('nombre', 'Programador')->first();
        $rolAdministrador = Roles::where('nombre', 'Administrador')->first();

        // Crear usuarios
        if ($persona1 && $rolProgramador) {
            User::create([
                'id_persona'        => $persona1->id_persona,
                'email'             => $persona1->correo,
                'foto'              => 'fotos_usuarios/usuario.png',
                'password'          => Hash::make('123'),
                'rol_id'            => $rolProgramador->id,
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]);
        }

        if ($persona2 && $rolAdministrador) {
            User::create([
                'id_persona'        => $persona2->id_persona,
                'email'             => $persona2->correo,
                'foto'              => 'fotos_usuarios/usuario.png',
                'password'          => Hash::make('123'),
                'rol_id'            => $rolAdministrador->id,
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ]);
        }
    }
}
