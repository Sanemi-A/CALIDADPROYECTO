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
        $usuarios = User::with(['role', 'persona'])->get();
        $roles = Roles::all();

        return view('admin.usuarios', compact('usuarios', 'roles'));
    }



    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_persona' => 'required|exists:personas,id_persona|unique:users,id_persona',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'rol_id' => 'required|exists:roles,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $rutaFoto = 'fotos_usuarios/usuario.png';
            if ($request->hasFile('foto')) {
                $rutaFoto = $request->file('foto')->store('fotos_usuarios', 'public');
            }

            User::create([
                'id_persona' => $request->id_persona,
                'email' => strtolower($request->email),
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

            // Validar solo lo que se está enviando
            $request->validate([
                'email'  => 'required|email|unique:users,email,' . $id,
                'rol_id' => 'required|exists:roles,id',
                'foto'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Actualizar correo y rol
            $user->email  = strtolower($request->email);
            $user->rol_id = $request->rol_id;

            // Si se subió una nueva foto, reemplazar la anterior
            if ($request->hasFile('foto')) {
                if (
                    $user->foto &&
                    $user->foto !== 'fotos_usuarios/usuario.png' &&
                    Storage::disk('public')->exists($user->foto)
                ) {
                    Storage::disk('public')->delete($user->foto);
                }

                $user->foto = $request->file('foto')->store('fotos_usuarios', 'public');
            }

            $user->save();

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
