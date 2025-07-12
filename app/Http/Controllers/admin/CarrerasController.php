<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use Illuminate\Http\Request;

class CarrerasController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return view('admin.carreras', compact('carreras'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:carreras,nombre',
                'prefijo' => 'required|string|max:5|unique:carreras,prefijo',
            ]);

            Carrera::create([
                'nombre' => ucfirst(strtolower($request->nombre)),
                'prefijo' => strtoupper($request->prefijo),
            ]);

            session()->flash('toast_message', 'Carrera creada correctamente.');
            session()->flash('toast_type', 'success');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al crear la carrera: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('carreras');
    }

    public function update(Request $request, $id)
    {
        try {
            $carrera = Carrera::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255|unique:carreras,nombre,' . $id . ',id_carrera',
                'prefijo' => 'required|string|max:5|unique:carreras,prefijo,' . $id . ',id_carrera',
            ]);

            $carrera->nombre = ucfirst(strtolower($request->nombre));
            $carrera->prefijo = strtoupper($request->prefijo);
            $carrera->save();

            session()->flash('toast_message', 'Carrera actualizada correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al actualizar la carrera: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('carreras');
    }

    public function destroy($id)
    {
        try {
            $carrera = Carrera::findOrFail($id);
            $carrera->delete();

            session()->flash('toast_message', 'Carrera eliminada correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al eliminar la carrera: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('carreras');
    }
}
