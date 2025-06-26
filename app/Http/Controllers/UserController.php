<?php

namespace App\Http\Controllers;

use App\Models\User; // Importar el modelo User
use App\Models\Roles; // Importar el modelo Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Importar Hash para cifrar contraseñas
use Illuminate\Support\Facades\Storage; // Importar Storage para manejar archivos

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // UserController.php


    public function index()
    {
        // Obtener usuarios con sus roles
        $usuarios = User::with('role')->get();
        $roles = Roles::all(); // Obtener todos los roles

        // Pasar ambas variables a la vista
        return view('admin.usuarios', compact('usuarios', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::all(); // Obtener todos los roles
        return view('admin.usuarios', compact('roles')); // Retornar la vista de creación
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'dni' => 'nullable|numeric|unique:users',
                'nombres' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'rol_id' => 'required|exists:roles,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Ruta por defecto si no se sube una imagen
            $rutaFoto = 'fotos_usuarios/usuario.png';

            // Si se sube una imagen, se almacena en el disco 'public'
            if ($request->hasFile('foto')) {
                $rutaFoto = $request->file('foto')->store('fotos_usuarios', 'public');
            }

            // Creación del usuario
            User::create([
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol_id' => $request->rol_id,
                'foto' => $rutaFoto,
            ]);

            session()->flash('toast_message', 'Usuario creado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al crear el usuario: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('usuarios');
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Buscar el usuario
        $roles = Roles::all(); // Obtener todos los roles
        return view('admin.usuarios', compact('user', 'roles')); // Retornar la vista de edición
    }

    /**
     * Update the specified resource in storage.
     */
    

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'dni' => 'nullable|numeric|unique:users,dni,' . $id,
                'nombres' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'rol_id' => 'required|exists:roles,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $datos = $request->only([
                'dni',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'email',
                'rol_id'
            ]);

            // Si se sube una nueva foto
            if ($request->hasFile('foto')) {
                // Solo elimina la foto anterior si no es la imagen por defecto
                if ($user->foto !== 'fotos_usuarios/usuario.png' && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Guarda la nueva foto
                $rutaFoto = $request->file('foto')->store('fotos_usuarios', 'public');
                $datos['foto'] = $rutaFoto;
            }

            $user->update($datos);

            session()->flash('toast_message', 'Usuario actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al actualizar el usuario: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('usuarios');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Eliminar la foto si no es la imagen por defecto
            if ($user->foto !== 'fotos_usuarios/usuario.png' && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->delete();

            session()->flash('toast_message', 'Usuario eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al eliminar el usuario: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('usuarios');
    }
}
