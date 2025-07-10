<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CursoHorario;
use App\Models\Curso;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CursosHorariosController extends Controller
{
    public function index()
    {
        return view('admin.cursos_horarios');
    }

    public function listar(Request $request)
    {
        $queryBase = DB::table('curso_horarios')
            ->join('cursos', 'curso_horarios.id_curso', '=', 'cursos.id_curso')
            ->leftJoin('docentes', 'curso_horarios.id_docente', '=', 'docentes.id_docente')
            ->leftJoin('personas', 'docentes.id_persona', '=', 'personas.id_persona')
            ->select(
                'curso_horarios.id_horario',
                'curso_horarios.hora_inicio',
                'curso_horarios.hora_fin',
                'curso_horarios.duracion_meses',
                'curso_horarios.modalidad',
                'curso_horarios.precio_mensual',
                'curso_horarios.estado',
                'cursos.nombre_curso',
                DB::raw("CONCAT(personas.nombres, ' ', personas.apellido_paterno, ' ', personas.apellido_materno) AS nombre_docente")
            );

        $totalRecords = $queryBase->count();
        $query = clone $queryBase;

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->where('cursos.nombre_curso', 'like', "%{$search}%")
                    ->orWhere('curso_horarios.modalidad', 'like', "%{$search}%")
                    ->orWhere('curso_horarios.estado', 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(personas.nombres, ' ', personas.apellido_paterno, ' ', personas.apellido_materno)"), 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();
        $query->orderBy('curso_horarios.id_horario', 'desc');

        $data = $query->offset($request->input('start'))
            ->limit($request->input('length'))
            ->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_curso'        => 'required|exists:cursos,id_curso',
                'id_docente'      => 'nullable|exists:docentes,id_docente',
                'hora_inicio'     => 'required|date_format:H:i',
                'hora_fin'        => 'required|date_format:H:i|after:hora_inicio',
                'duracion_meses'  => 'required|integer|min:1|max:24',
                'modalidad'       => 'required|string|max:50',
                'precio_mensual'  => 'required|numeric|min:0',
                'estado'          => ['required', Rule::in(['ACTIVO', 'INACTIVO', 'FINALIZADO', 'ESPERA'])],
            ]);

            $horario = CursoHorario::create($request->all());

            Log::info('Curso horario registrado', [
                'usuario_id' => Auth::id(),
                'id_horario' => $horario->id_horario
            ]);

            session()->flash('toast_message', 'Curso horario registrado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (ValidationException $e) {
            session()->flash('toast_message', 'Error de validación: ' . implode(' ', $e->validator->errors()->all()));
            session()->flash('toast_type', 'warning');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Log::error('Error al registrar curso horario', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error inesperado: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
            return redirect()->back()->withInput();
        }

        return redirect()->route('curso_horarios');
    }

    public function update(Request $request, $id)
    {
        try {
            $horario = CursoHorario::findOrFail($id);

            $request->validate([
                'id_curso'        => 'required|exists:cursos,id_curso',
                'id_docente'      => 'nullable|exists:docentes,id_docente',
                'hora_inicio'     => 'required|date_format:H:i',
                'hora_fin'        => 'required|date_format:H:i|after:hora_inicio',
                'duracion_meses'  => 'required|integer|min:1|max:24',
                'modalidad'       => 'required|string|max:50',
                'precio_mensual'  => 'required|numeric|min:0',
                'estado'          => ['required', Rule::in(['ACTIVO', 'INACTIVO', 'FINALIZADO', 'ESPERA'])],
            ]);

            $horario->update($request->all());

            Log::info('Curso horario actualizado', [
                'usuario_id' => Auth::id(),
                'id_horario' => $horario->id_horario
            ]);

            session()->flash('toast_message', 'Curso horario actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            Log::error('Error al actualizar curso horario', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error al actualizar: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('curso_horarios');
    }

    public function destroy($id)
    {
        try {
            $horario = CursoHorario::findOrFail($id);
            $horario->delete();

            Log::info('Curso horario eliminado', [
                'usuario_id' => Auth::id(),
                'id_horario' => $id
            ]);

            session()->flash('toast_message', 'Curso horario eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            Log::error('Error al eliminar curso horario', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error al eliminar horario.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('curso_horarios');
    }
}
