<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContratoDocente;
use App\Models\Docente;
use App\Models\CursoHorario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ContratoDocenteController extends Controller
{
    public function index()
    {
        $horarios = CursoHorario::with('curso')
            ->whereNull('id_docente')
            ->get();

        return view('admin.contratos_docentes', compact('horarios'));
    }



    public function listar(Request $request)
    {
        $queryBase = DB::table('contratos_docentes')
            ->join('docentes', 'contratos_docentes.id_docente', '=', 'docentes.id_docente')
            ->join('personas', 'docentes.id_persona', '=', 'personas.id_persona')
            ->join('curso_horarios', 'contratos_docentes.id_horario', '=', 'curso_horarios.id_horario')
            ->join('cursos', 'curso_horarios.id_curso', '=', 'cursos.id_curso')
            ->select(
                'contratos_docentes.id_contrato',
                'contratos_docentes.fecha_inicio',
                'contratos_docentes.fecha_fin',
                'contratos_docentes.tipo_contrato',
                'contratos_docentes.estado',
                'contratos_docentes.observacion',
                DB::raw("CONCAT(personas.nombres, ' ', personas.apellido_paterno, ' ', personas.apellido_materno) AS nombre_docente"),
                'cursos.nombre_curso',
                'curso_horarios.hora_inicio',
                'curso_horarios.hora_fin'
            );

        $totalRecords = $queryBase->count();
        $query = clone $queryBase;

        // Búsqueda global
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->where('personas.nombres', 'like', "%{$search}%")
                    ->orWhere('personas.apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('personas.apellido_materno', 'like', "%{$search}%")
                    ->orWhere('cursos.nombre_curso', 'like', "%{$search}%")
                    ->orWhere('contratos_docentes.tipo_contrato', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();
        $data = $query
            ->orderByDesc('contratos_docentes.id_contrato')
            ->offset($request->input('start'))
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
                'id_docente'     => 'required|exists:docentes,id_docente',
                'id_horario'     => 'required|exists:curso_horarios,id_horario',
                'fecha_inicio'   => 'required|date',
                'fecha_fin'      => 'required|date|after_or_equal:fecha_inicio',
                'tipo_contrato'  => 'required|string|max:50',
                'estado' => ['nullable', Rule::in(['VIGENTE', 'FINALIZADO', 'ANULADO'])],
                'observacion'    => 'nullable|string',
            ]);

            $docente = Docente::findOrFail($request->id_docente);

            // Verificar estado del docente
            if (in_array($docente->estado, ['SUSPENDIDO', 'INHABILITADO', 'RETIRADO'])) {
                session()->flash('toast_message', 'No se puede asignar contrato. El docente está: ' . $docente->estado);
                session()->flash('toast_type', 'warning');
                return redirect()->back()->withInput();
            }

            DB::beginTransaction();

            // Crear el contrato
            $contrato = ContratoDocente::create($request->all());

            // Asignar el docente al horario
            DB::table('curso_horarios')
                ->where('id_horario', $request->id_horario)
                ->update(['id_docente' => $request->id_docente]);

            // Cambiar estado del docente a ACTIVO si estaba INACTIVO
            if ($docente->estado === 'INACTIVO') {
                $docente->update(['estado' => 'ACTIVO']);
            }

            DB::commit();

            Log::info('Contrato de docente registrado', [
                'usuario_id' => Auth::id(),
                'id_contrato' => $contrato->id_contrato
            ]);

            session()->flash('toast_message', 'Contrato registrado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (ValidationException $e) {
            DB::rollBack();
            session()->flash('toast_message', 'Error de validación: ' . implode(' ', $e->validator->errors()->all()));
            session()->flash('toast_type', 'warning');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar contrato docente', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error inesperado: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
            return redirect()->back()->withInput();
        }

        return redirect()->route('contratos_docentes');
    }


    public function update(Request $request, $id)
    {
        try {
            $contrato = ContratoDocente::findOrFail($id);

            $request->validate([
                'fecha_inicio'   => 'required|date',
                'fecha_fin'      => 'required|date|after_or_equal:fecha_inicio',
                'tipo_contrato'  => 'required|string|max:50',
                'estado'         => ['required', Rule::in(['VIGENTE', 'FINALIZADO', 'ANULADO'])],
                'observacion'    => 'nullable|string',
            ]);

            DB::beginTransaction();

            $contrato->update([
                'fecha_inicio'   => $request->fecha_inicio,
                'fecha_fin'      => $request->fecha_fin,
                'tipo_contrato'  => $request->tipo_contrato,
                'estado'         => $request->estado,
                'observacion'    => $request->observacion,
            ]);

            // Si el contrato termina o se anula, poner al docente como INACTIVO
            if (in_array($request->estado, ['FINALIZADO', 'ANULADO'])) {
                $docente = $contrato->docente; // Usa la relación con el modelo
                if ($docente->estado === 'ACTIVO') {
                    $docente->update(['estado' => 'INACTIVO']);
                }
            }

            DB::commit();

            Log::info('Contrato docente actualizado', [
                'usuario_id' => Auth::id(),
                'id_contrato' => $contrato->id_contrato
            ]);

            session()->flash('toast_message', 'Contrato actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (ValidationException $e) {
            DB::rollBack();
            session()->flash('toast_message', 'Error de validación: ' . implode(' ', $e->validator->errors()->all()));
            session()->flash('toast_type', 'warning');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar contrato docente', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error inesperado al actualizar contrato.');
            session()->flash('toast_type', 'error');
            return redirect()->back()->withInput();
        }

        return redirect()->route('contratos_docentes');
    }



    public function destroy($id)
    {
        try {
            $contrato = ContratoDocente::findOrFail($id);

            // Desasociar docente del horario
            DB::table('curso_horarios')
                ->where('id_horario', $contrato->id_horario)
                ->update(['id_docente' => null]);

            // Eliminar contrato
            $contrato->delete();

            Log::info('Contrato docente eliminado', [
                'usuario_id' => Auth::id(),
                'id_contrato' => $id
            ]);

            session()->flash('toast_message', 'Contrato eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            Log::error('Error al eliminar contrato docente', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error al eliminar contrato.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('contratos_docentes');
    }
}
