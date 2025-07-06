<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        return view('admin.roles', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100|unique:roles,nombre',
            ]);

            Roles::create([
                'nombre' => ucfirst(strtolower($request->nombre)),
            ]);

            session()->flash('toast_message', 'Rol creado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al crear el rol: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('roles');
    }

    public function update(Request $request, $id)
    {
        try {
            $rol = Roles::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:100|unique:roles,nombre,' . $id,
            ]);

            $rol->nombre = ucfirst(strtolower($request->nombre));
            $rol->save();

            session()->flash('toast_message', 'Rol actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al actualizar el rol: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('roles');
    }

    public function destroy($id)
    {
        try {
            $rol = Roles::findOrFail($id);
            $rol->delete();

            session()->flash('toast_message', 'Rol eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al eliminar el rol: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('roles');
    }
}
