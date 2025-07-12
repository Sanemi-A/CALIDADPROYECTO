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
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            ->join('personas as est', 'estudiantes.id_persona', '=', 'est.id_persona')
            ->join('curso_horarios', 'matriculas.id_horario', '=', 'curso_horarios.id_horario')
            ->join('cursos', 'curso_horarios.id_curso', '=', 'cursos.id_curso')
            ->join('niveles', 'cursos.id_nivel', '=', 'niveles.id_nivel')
            ->join('programas', 'cursos.id_programa', '=', 'programas.id_programa')
            ->leftJoin('users', 'matriculas.id_usuario_registro', '=', 'users.id')
            ->leftJoin('personas as usr', 'users.id_persona', '=', 'usr.id_persona')
            ->select(
                'matriculas.id_matricula',
                'matriculas.id_estudiante',
                'matriculas.id_horario',
                'matriculas.fecha_registro',
                'matriculas.tipo_entrega',
                'matriculas.cod_pago',
                'matriculas.entidad_pago',
                'matriculas.codigo_operacion',
                'matriculas.monto',
                'matriculas.observacion',
                'matriculas.pago_completo',
                'matriculas.tipo_beca',
                'matriculas.documento_beca',
                'matriculas.ruta_documento',
                'matriculas.ruta_voucher_mensualidades',
                'matriculas.estado',
                'matriculas.validado',

                'est.nombres as estudiante_nombres',
                'est.apellido_paterno as estudiante_apellido_paterno',
                'est.apellido_materno as estudiante_apellido_materno',
                'est.documento',

                'cursos.nombre_curso',
                'niveles.nombre as nivel',
                'programas.nombre as programa',

                'curso_horarios.modalidad',
                'curso_horarios.duracion_meses',
                'curso_horarios.precio_mensual',
                'curso_horarios.hora_inicio',
                'curso_horarios.hora_fin',
                'curso_horarios.lunes',
                'curso_horarios.martes',
                'curso_horarios.miercoles',
                'curso_horarios.jueves',
                'curso_horarios.viernes',
                'curso_horarios.sabado',
                'curso_horarios.domingo',

                DB::raw("CONCAT(usr.nombres, ' ', usr.apellido_paterno) as responsable")
            );



        // Total sin filtros
        $totalRecords = $queryBase->count();

        // Clonar para filtros
        $query = clone $queryBase;

        // Filtro global
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $query->where(function ($q) use ($search) {
                $q->where('est.nombres', 'like', "%{$search}%")
                    ->orWhere('est.apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('est.apellido_materno', 'like', "%{$search}%")
                    ->orWhere('cursos.nombre_curso', 'like', "%{$search}%")
                    ->orWhere('matriculas.estado', 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(usr.nombres, ' ', usr.apellido_paterno)"), 'like', "%{$search}%");
            });
        }

        // Total con filtro
        $recordsFiltered = $query->count();

        // Ordenamiento
        $query->orderByDesc('matriculas.id_matricula');

        // Validar offset y limit
        $start = intval($request->input('start', 0));
        $length = intval($request->input('length', 10));
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

                // Beca
                'tipo_beca'           => 'nullable|string|max:100',
                'documento_beca'      => 'nullable|string|max:255',
                'ruta_documento'      => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'descuento_beca'      => 'nullable|integer|min:0|max:100',

                // Pago
                'tipo_entrega'        => ['nullable', Rule::in(['fisico', 'virtual'])],
                'codigo_operacion'    => 'nullable|string|max:100',
                'entidad_pago'        => 'nullable|string|max:100',
                'cod_pago'            => 'nullable|string|max:100',
                'monto'               => 'nullable|numeric|min:0',
                'ruta_voucher'        => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'ruta_voucher_mensualidades' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',


                // Otros
                'observacion'         => 'nullable|string',
                'pago_completo'       => 'nullable|boolean',
            ]);

            $yaMatriculado = Matricula::where('id_estudiante', $request->id_estudiante)
                ->where('id_horario', $request->id_horario)
                ->whereNull('deleted_at') // considerar soft deletes
                ->exists();

            if ($yaMatriculado) {
                return redirect()->back()
                    ->withInput()
                    ->with([
                        'toast_message' => 'El estudiante ya está matriculado en este horario.',
                        'toast_type' => 'warning'
                    ]);
            }

            $voucherPath = $request->hasFile('ruta_voucher')
                ? $request->file('ruta_voucher')->store('matriculas/vouchers', 'public')
                : null;

            $becaPath = $request->hasFile('ruta_documento')
                ? $request->file('ruta_documento')->store('matriculas/archivos', 'public')
                : null;

            $voucherMensualidadesPath = $request->hasFile('ruta_voucher_mensualidades')
                ? $request->file('ruta_voucher_mensualidades')->store('matriculas/vouchers_mensualidades', 'public')
                : null;



            $matricula = Matricula::create([
                'id_estudiante'        => $request->id_estudiante,
                'id_horario'           => $request->id_horario,
                'fecha_registro'       => $request->fecha_registro,

                // Beca
                'tipo_beca'            => $request->tipo_beca,
                'documento_beca'       => $request->documento_beca,
                'ruta_documento'       => $becaPath,
                'descuento_beca'       => $request->descuento_beca,

                // Pago
                'tipo_entrega'         => $request->tipo_entrega ?? 'fisico',
                'codigo_operacion'     => $request->codigo_operacion,
                'entidad_pago'         => $request->entidad_pago,
                'cod_pago'             => $request->cod_pago,
                'monto'                => $request->monto,
                'ruta_voucher'         => $voucherPath,
                'pago_completo'        => $request->boolean('pago_completo'),
                'ruta_voucher_mensualidades' => $voucherMensualidadesPath,

                // Otros
                'observacion'          => $request->observacion,
                'estado'               => 'VIGENTE',
                'validado'             => true,
                'exonerado'            => ($request->descuento_beca == 100),
                'id_usuario_registro'  => Auth::id(),
            ]);

            Log::info('Matrícula registrada', [
                'usuario_id'    => Auth::id(),
                'matricula_id'  => $matricula->id_matricula,
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

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id_horario'                   => 'required|exists:curso_horarios,id_horario',
                'fecha_registro'               => 'required|date',

                // Beca
                'tipo_beca'                    => 'nullable|string|max:100',
                'documento_beca'               => 'nullable|string|max:255',
                'ruta_documento'               => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'descuento_beca'              => 'nullable|integer|min:0|max:100',

                // Pago
                'tipo_entrega'                 => ['nullable', Rule::in(['fisico', 'virtual'])],
                'codigo_operacion'            => 'nullable|string|max:100',
                'entidad_pago'                => 'nullable|string|max:100',
                'cod_pago'                    => 'nullable|string|max:100',
                'monto'                       => 'nullable|numeric|min:0',
                'ruta_voucher'               => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
                'ruta_voucher_mensualidades' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',

                // Otros
                'observacion'                => 'nullable|string',
                'pago_completo'              => 'nullable|boolean',
            ]);

            $matricula = Matricula::findOrFail($id);

            // Archivos: voucher matrícula
            if ($request->hasFile('ruta_voucher')) {
                if ($matricula->ruta_voucher && Storage::disk('public')->exists($matricula->ruta_voucher)) {
                    Storage::disk('public')->delete($matricula->ruta_voucher);
                }
                $matricula->ruta_voucher = $request->file('ruta_voucher')->store('matriculas/vouchers', 'public');
            }

            // Archivos: documento beca
            if ($request->hasFile('ruta_documento')) {
                if ($matricula->ruta_documento && Storage::disk('public')->exists($matricula->ruta_documento)) {
                    Storage::disk('public')->delete($matricula->ruta_documento);
                }
                $matricula->ruta_documento = $request->file('ruta_documento')->store('matriculas/becas', 'public');
            }

            // Archivos: voucher mensualidades
            if ($request->hasFile('ruta_voucher_mensualidades')) {
                if ($matricula->ruta_voucher_mensualidades && Storage::disk('public')->exists($matricula->ruta_voucher_mensualidades)) {
                    Storage::disk('public')->delete($matricula->ruta_voucher_mensualidades);
                }
                $matricula->ruta_voucher_mensualidades = $request->file('ruta_voucher_mensualidades')->store('matriculas/mensualidades', 'public');
            }

            // Datos de horario y fecha
            $matricula->id_horario        = $request->id_horario;
            $matricula->fecha_registro    = $request->fecha_registro;

            // Pago
            $matricula->tipo_entrega      = $request->tipo_entrega ?? 'fisico';
            $matricula->codigo_operacion  = $request->codigo_operacion;
            $matricula->entidad_pago      = $request->entidad_pago;
            $matricula->cod_pago          = $request->cod_pago;
            $matricula->monto             = $request->monto;
            $matricula->pago_completo     = $request->boolean('pago_completo');

            // Beca
            $matricula->tipo_beca         = $request->tipo_beca;
            $matricula->documento_beca    = $request->documento_beca;
            $matricula->descuento_beca    = $request->descuento_beca;
            $matricula->exonerado         = ($request->descuento_beca == 100);

            // Otros
            $matricula->observacion       = $request->observacion;

            $matricula->save();

            Log::info('Matrícula actualizada', [
                'usuario_id'    => Auth::id(),
                'matricula_id'  => $matricula->id_matricula,
            ]);

            session()->flash('toast_message', 'Matrícula actualizada correctamente.');
            session()->flash('toast_type', 'success');
        } catch (ValidationException $e) {
            session()->flash('toast_message', 'Error de validación: ' . implode(' ', $e->validator->errors()->all()));
            session()->flash('toast_type', 'warning');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Log::error('Error al actualizar matrícula', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error inesperado: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
            return redirect()->back()->withInput();
        }

        return redirect()->route('matriculas');
    }



    public function destroy($id)
    {
        try {
            $matricula = Matricula::with([
                'estudiante.persona',
                'horario.curso.nivel',
                'horario.curso.programa'
            ])->findOrFail($id);

            // Eliminar archivos si existen (ahora incluye mensualidades)
            $archivos = [
                $matricula->ruta_documento,
                $matricula->ruta_voucher,
                $matricula->ruta_voucher_mensualidades
            ];

            foreach ($archivos as $archivo) {
                if ($archivo && Storage::disk('public')->exists($archivo)) {
                    Storage::disk('public')->delete($archivo);
                }
            }

            // Guardar datos relevantes antes de eliminar
            $datosMatricula = [
                'matricula_id'       => $matricula->id_matricula,
                'fecha_registro'     => $matricula->fecha_registro,
                'estado'             => $matricula->estado,
                'monto'              => $matricula->monto,
                'pago_completo'      => $matricula->pago_completo,
                'estudiante'         => optional($matricula->estudiante->persona)->nombres . ' ' .
                    optional($matricula->estudiante->persona)->apellido_paterno . ' ' .
                    optional($matricula->estudiante->persona)->apellido_materno,
                'curso'              => optional($matricula->horario->curso)->nombre_curso,
                'nivel'              => optional($matricula->horario->curso->nivel)->nombre,
                'programa'           => optional($matricula->horario->curso->programa)->nombre,
            ];

            $matricula->delete();

            Log::info('Matrícula eliminada por usuario', [
                'usuario_id'      => Auth::id(),
                'usuario_nombre'  => Auth::user()->name,
                'datos_matricula' => $datosMatricula
            ]);

            return redirect()->route('matriculas')->with([
                'toast_message' => 'Matrícula eliminada correctamente.',
                'toast_type' => 'warning'
            ]);
        } catch (ModelNotFoundException $e) {
            Log::warning('Matrícula no encontrada para eliminar', ['id' => $id]);
            return redirect()->route('matriculas')->with([
                'toast_message' => 'La matrícula no existe o ya fue eliminada.',
                'toast_type' => 'warning'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar matrícula', ['error' => $e->getMessage()]);
            return redirect()->route('matriculas')->with([
                'toast_message' => 'Error inesperado al eliminar la matrícula.',
                'toast_type' => 'error'
            ]);
        }
    }
}
