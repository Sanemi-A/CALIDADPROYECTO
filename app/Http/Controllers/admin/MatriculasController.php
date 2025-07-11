<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\CursoHorario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class MatriculasController extends Controller
{
    public function index()
    {
        $horarios = DB::table('curso_horarios')
            ->join('cursos', 'curso_horarios.id_curso', '=', 'cursos.id_curso')
            ->select(
                'curso_horarios.id_horario',
                'cursos.nombre_curso',
                'curso_horarios.hora_inicio',
                'curso_horarios.hora_fin'
            )
            ->where('curso_horarios.estado', 'ESPERA')
            ->orderBy('cursos.nombre_curso')
            ->get();

        return view('admin.matriculas', compact('horarios'));
    }


    public function listar(Request $request)
    {
        $queryBase = DB::table('matriculas')
            ->join('estudiantes', 'matriculas.id_estudiante', '=', 'estudiantes.id_estudiante')
            ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
            ->join('curso_horarios', 'matriculas.id_horario', '=', 'curso_horarios.id_horario')
            ->join('cursos', 'curso_horarios.id_curso', '=', 'cursos.id_curso')
            ->select(
                'matriculas.id_matricula',
                'personas.nombres',
                'personas.apellido_paterno',
                'personas.apellido_materno',
                'cursos.nombre_curso as curso',
                'matriculas.fecha_registro',
                'matriculas.estado',
                'matriculas.validado'
            );

        // Total sin filtros
        $totalRecords = $queryBase->count();

        // Clonar para filtros
        $query = clone $queryBase;

        // Filtro global
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $query->where(function ($q) use ($search) {
                $q->where('personas.nombres', 'like', "%{$search}%")
                    ->orWhere('personas.apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('personas.apellido_materno', 'like', "%{$search}%")
                    ->orWhere('cursos.nombre', 'like', "%{$search}%")
                    ->orWhere('matriculas.estado', 'like', "%{$search}%");
            });
        }

        // Total con filtro
        $recordsFiltered = $query->count();

        // Ordenamiento
        $query->orderByDesc('matriculas.id_matricula');

        // Validar offset y limit
        $start = intval($request->input('start', 0));
        $length = intval($request->input('length', 10));

        // Evitar LIMIT sin número válido
        if ($length <= 0) {
            $length = 10;
        }

        // Obtener resultados paginados
        $data = $query->offset($start)
            ->limit($length)
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
                'id_estudiante'       => 'required|exists:estudiantes,id_estudiante',
                'id_horario'          => 'required|exists:curso_horarios,id_horario',
                'fecha_registro'      => 'required|date',
                'responsable'         => 'required|string|max:100',

                'tipo_beca'           => 'nullable|string|max:100',
                'documento_beca'      => 'nullable|string|max:255',
                'ruta_documento'      => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'descuento_beca'      => 'nullable|integer|min:0|max:100',

                'voucher'             => 'nullable|string|max:100',
                'tipo_entrega'        => ['required', Rule::in(['fisico', 'virtual'])],
                'codigo_operacion'    => 'nullable|string|max:100',
                'entidad_pago'        => 'nullable|string|max:100',
                'cod_pago'            => 'nullable|string|max:100',
                'monto'               => 'nullable|numeric|min:0',
                'ruta_voucher'        => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                'observacion'         => 'nullable|string',
            ]);

            $voucherPath = $request->hasFile('ruta_voucher')
                ? $request->file('ruta_voucher')->store('matriculas/vouchers', 'public')
                : null;

            $becaPath = $request->hasFile('ruta_documento')
                ? $request->file('ruta_documento')->store('matriculas/becas', 'public')
                : null;

            $matricula = Matricula::create([
                'id_estudiante'     => $request->id_estudiante,
                'id_horario'        => $request->id_horario,
                'fecha_registro'    => $request->fecha_registro,
                'responsable'       => $request->responsable,

                'tipo_beca'         => $request->tipo_beca,
                'documento_beca'    => $request->documento_beca,
                'ruta_documento'    => $becaPath,
                'descuento_beca'    => $request->descuento_beca,

                'voucher'           => $request->voucher,
                'tipo_entrega'      => $request->tipo_entrega,
                'codigo_operacion'  => $request->codigo_operacion,
                'entidad_pago'      => $request->entidad_pago,
                'cod_pago'          => $request->cod_pago,
                'monto'             => $request->monto,
                'ruta_voucher'      => $voucherPath,

                'observacion'       => $request->observacion,
                'estado'            => 'VIGENTE',
                'validado'          => false,
                'id_usuario_registro' => Auth::id(),
            ]);

            Log::info('Matrícula registrada', [
                'usuario_id' => Auth::id(),
                'matricula_id' => $matricula->id_matricula,
            ]);

            session()->flash('toast_message', 'Matrícula registrada correctamente.');
            session()->flash('toast_type', 'success');
        } catch (ValidationException $e) {
            session()->flash('toast_message', 'Error de validación: ' . implode(' ', $e->validator->errors()->all()));
            session()->flash('toast_type', 'warning');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Log::error('Error al registrar matrícula', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error inesperado: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
            return redirect()->back()->withInput();
        }

        return redirect()->route('matriculas');
    }

    public function destroy($id)
    {
        try {
            $matricula = Matricula::findOrFail($id);

            if ($matricula->ruta_documento && Storage::disk('public')->exists($matricula->ruta_documento)) {
                Storage::disk('public')->delete($matricula->ruta_documento);
            }

            if ($matricula->ruta_voucher && Storage::disk('public')->exists($matricula->ruta_voucher)) {
                Storage::disk('public')->delete($matricula->ruta_voucher);
            }

            $matricula->delete();

            Log::info('Matrícula eliminada', [
                'usuario_id' => Auth::id(),
                'matricula_id' => $id,
            ]);

            session()->flash('toast_message', 'Matrícula eliminada correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            Log::error('Error al eliminar matrícula', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error al eliminar la matrícula.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('matriculas');
    }
}
