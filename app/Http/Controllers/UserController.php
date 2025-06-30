<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function index()
    {
        $usuarios = User::with('role')->get();
        $roles = Roles::all();

        return view('admin.usuarios', compact('usuarios', 'roles'));
    }



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
            $rutaFoto = 'fotos_usuarios/usuario.png';

            if ($request->hasFile('foto')) {
                $rutaFoto = $request->file('foto')->store('fotos_usuarios', 'public');
            }

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

            if ($request->hasFile('foto')) {
                if ($user->foto !== 'fotos_usuarios/usuario.png' && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }

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


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

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

    public function updatePassword(Request $request, $id)
    {
        try {
            // Validación
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Buscar usuario
            $user = User::findOrFail($id);

            // Actualizar contraseña
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('toast_message', 'Contraseña actualizada correctamente.');
            session()->flash('toast_type', 'success');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al actualizar la contraseña: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('usuarios');
    }
}
