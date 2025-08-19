<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Nivel;
use App\Models\Programa;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index()
    {
        $cursos = Curso::with(['programa', 'nivel'])->get();
        $programas = Programa::all();
        $niveles = Nivel::all();

        return view('admin.cursos', compact('cursos', 'programas', 'niveles'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_curso'   => 'required|string|max:100|unique:cursos,nombre_curso',
                'id_programa'    => 'required|exists:programas,id_programa',
                'nomenclatura'   => 'required|string|max:100',
                'id_nivel'       => 'required|exists:niveles,id_nivel',
                'estado'         => 'in:ACTIVO,INACTIVO,CULMINADO',
            ]);

            Curso::create([
                'nombre_curso'  => $request->nombre_curso,
                'id_programa'   => $request->id_programa,
                'nomenclatura'  => $request->nomenclatura,
                'id_nivel'      => $request->id_nivel,
                'estado'        => $request->estado ?? 'ACTIVO',
            ]);

            session()->flash('toast_message', 'Curso creado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al crear el curso: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('cursos');
    }

    public function update(Request $request, $id)
    {
        try {
            $curso = Curso::findOrFail($id);

            $request->validate([
                'nombre_curso'   => 'required|string|max:100|unique:cursos,nombre_curso,' . $id . ',id_curso',
                'id_programa'    => 'required|exists:programas,id_programa',
                'nomenclatura'   => 'required|string|max:100',
                'id_nivel'       => 'required|exists:niveles,id_nivel',
                'estado'         => 'in:ACTIVO,INACTIVO,CULMINADO',
            ]);

            $curso->update([
                'nombre_curso'  => $request->nombre_curso,
                'id_programa'   => $request->id_programa,
                'nomenclatura'  => $request->nomenclatura,
                'id_nivel'      => $request->id_nivel,
                'estado'        => $request->estado,
            ]);

            session()->flash('toast_message', 'Curso actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al actualizar el curso: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('cursos');
    }

    public function destroy($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            $curso->delete();

            session()->flash('toast_message', 'Curso eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            session()->flash('toast_message', 'Error al eliminar el curso: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('cursos');
    }

    public function buscarAjax(Request $request)
    {
        $query = $request->input('query');

        $cursos = Curso::with(['programa', 'nivel'])
            ->where(function ($q) use ($query) {
                $q->where('nombre_curso', 'like', "%{$query}%")
                    ->orWhere('nomenclatura', 'like', "%{$query}%");
            })
            ->select('id_curso', 'nombre_curso', 'nomenclatura', 'id_programa', 'id_nivel', 'estado')
            ->limit(10)
            ->get();

        return response()->json($cursos);
    }
}
