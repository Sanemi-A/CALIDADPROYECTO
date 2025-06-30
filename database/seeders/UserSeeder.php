<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener los roles para asignarlos a los usuarios
        $adminRole = Roles::where('nombre', 'Administrador')->first();
        $editorRole = Roles::where('nombre', 'Editor')->first();
        $userRole = Roles::where('nombre', 'Usuario')->first();

        // Crear usuarios de ejemplo con los campos correctos
        User::create([
            'dni' => '12345678',
            'nombres' => 'Michael Deyvis',
            'apellido_paterno' => 'Mamani',
            'apellido_materno' => 'Choqque',
            'email' => 'michael@gmail.edu.pe',
            'foto' => 'fotos_usuarios/usuario.png',
            'password' => '123',
            'rol_id' => $adminRole->id,
        ]);

        
    }
}
