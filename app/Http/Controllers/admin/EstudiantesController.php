<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\TipoAlumno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EstudiantesController extends Controller
{
    public function index()
    {

        $TipoAlumno = TipoAlumno::all();
        $Carrera = Carrera::all();

        return view('admin.estudiantes_lista', compact('TipoAlumno', 'Carrera'));
    }

    public function listar(Request $request)
    {
        $queryBase = DB::table('estudiantes')
            ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
            ->leftJoin('tipo_alumnos', 'estudiantes.id_tipo_alumno', '=', 'tipo_alumnos.id_tipo_alumno')
            ->leftJoin('carreras', 'estudiantes.id_carrera', '=', 'carreras.id_carrera')
            ->select(
                'estudiantes.id_estudiante',
                'estudiantes.id_persona',
                'estudiantes.id_tipo_alumno',
                'estudiantes.id_carrera',
                'personas.nombres as nombres',
                'personas.apellido_paterno as apellido_paterno',
                'personas.apellido_materno as apellido_materno',
                'personas.documento as documento',
                'estudiantes.codigo_estudiante',
                'tipo_alumnos.nombre as tipo_alumno',
                'carreras.nombre as carrera',
                'estudiantes.estado as estado',
                'estudiantes.estado_financiero as estado_financiero',
                'estudiantes.estado_disciplinario as estado_disciplinario',
                'estudiantes.foto as foto'
            );

        $totalRecords = $queryBase->count();
        $query = clone $queryBase;

        // Filtro global de búsqueda
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->where('personas.nombres', 'like', "%{$search}%")
                    ->orWhere('personas.apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('personas.apellido_materno', 'like', "%{$search}%")
                    ->orWhere('personas.documento', 'like', "%{$search}%")
                    ->orWhere('estudiantes.codigo_estudiante', 'like', "%{$search}%")
                    ->orWhere('tipo_alumnos.nombre', 'like', "%{$search}%")
                    ->orWhere('carreras.nombre', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        // Ordenamiento
        if ($request->has('order')) {
            $columnIndex = $request->input('order')[0]['column'];
            $columnName = $request->input('columns')[$columnIndex]['data'];
            $columnOrder = $request->input('order')[0]['dir'];

            $columnMap = [
                'nombres' => 'personas.nombres',
                'apellido_paterno' => 'personas.apellido_paterno',
                'apellido_materno' => 'personas.apellido_materno',
                'documento' => 'personas.documento',
                'codigo_estudiante' => 'estudiantes.codigo_estudiante',
                'tipo_alumno' => 'tipo_alumnos.nombre',
                'carrera' => 'carreras.nombre',
            ];

            if (isset($columnMap[$columnName])) {
                $query->orderBy($columnMap[$columnName], $columnOrder);
            }
        } else {
            $query->orderBy('estudiantes.id_estudiante', 'desc');
        }

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
                'id_persona' => [
                    'required',
                    'exists:personas,id_persona',
                    Rule::unique('estudiantes', 'id_persona')
                ],
                'id_tipo_alumno' => 'required|exists:tipo_alumnos,id_tipo_alumno',
                'id_carrera' => 'nullable|exists:carreras,id_carrera',
                'codigo_estudiante' => 'nullable|string|max:50|unique:estudiantes,codigo_estudiante',
                'estado' => 'nullable|in:ACTIVO,INACTIVO',
                'estado_financiero' => 'nullable|in:REGULAR,DEUDOR',
                'estado_disciplinario' => 'nullable|in:SIN_SANCION,SANCIONADO',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'id_persona.unique' => 'La persona seleccionada ya está registrada como estudiante.',
                'id_persona.required' => 'Debe seleccionar una persona.',
                'id_persona.exists' => 'La persona seleccionada no existe.',

                'id_tipo_alumno.required' => 'Debe seleccionar un tipo de alumno.',
                'id_tipo_alumno.exists' => 'El tipo de alumno seleccionado no es válido.',

                'id_carrera.required' => 'Debe seleccionar una carrera.',
                'id_carrera.exists' => 'La carrera seleccionada no existe.',

                'codigo_estudiante.required' => 'Debe ingresar el código del estudiante.',
                'codigo_estudiante.unique' => 'El código de estudiante ya está en uso.',

                'foto.image' => 'La foto debe ser una imagen válida.',
                'foto.mimes' => 'La foto debe ser en formato JPEG, PNG o JPG.',
                'foto.max' => 'La foto no debe superar los 2 MB.',
            ]);


            $tipoAlumno = TipoAlumno::find($request->id_tipo_alumno);

            if ($tipoAlumno && $tipoAlumno->nombre !== 'Particular') {
                $request->validate([
                    'id_carrera' => 'required|exists:carreras,id_carrera',
                    'codigo_estudiante' => 'required|string|max:50|unique:estudiantes,codigo_estudiante',
                ]);
            }

            // Obtener documento del estudiante
            $persona = \App\Models\Persona::findOrFail($request->id_persona);
            $documento = $persona->documento;

            $datos = $request->only([
                'id_persona',
                'id_tipo_alumno',
                'id_carrera',
                'codigo_estudiante',
            ]);

            $datos['estado'] = 'INACTIVO';
            $datos['estado_financiero'] = $request->estado_financiero ?? 'REGULAR';
            $datos['estado_disciplinario'] = $request->estado_disciplinario ?? 'SIN_SANCION';
            $datos['password'] = $documento;
            if ($request->hasFile('foto')) {
                $datos['foto'] = $request->file('foto')->store('fotos_estudiantes', 'public');
            } else {
                $datos['foto'] = 'fotos_estudiantes/estudiante.png';
            }

            $estudiante = Estudiante::create($datos);

            Log::info('Estudiante registrado', [
                'usuario_id' => Auth::id(),
                'estudiante_id' => $estudiante->id_estudiante,
                'datos' => $estudiante->toArray(),
            ]);

            session()->flash('toast_message', 'Estudiante registrado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (ValidationException $e) {
            // Captura los errores de validación y los muestra en la sesión
            $errores = implode(' ', $e->validator->errors()->all());

            session()->flash('toast_message', 'Error de validación: ' . $errores);
            session()->flash('toast_type', 'warning');

            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Log::error('Error al registrar estudiante', [
                'usuario_id' => Auth::id(),
                'error' => $e->getMessage(),
                'entrada' => $request->all(),
            ]);

            session()->flash('toast_message', 'Ocurrió un error inesperado: ' . $e->getMessage());
            session()->flash('toast_type', 'error');

            return redirect()->back()->withInput();
        }

        return redirect()->route('estudiantes');
    }




    public function update(Request $request, $id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);

            // Validación base
            $request->validate([
                'id_persona' => 'required|exists:personas,id_persona',
                'id_tipo_alumno' => 'required|exists:tipo_alumnos,id_tipo_alumno',
                'id_carrera' => 'nullable|exists:carreras,id_carrera',
                'codigo_estudiante' => 'nullable|string|max:50|unique:estudiantes,codigo_estudiante,' . $id . ',id_estudiante',
                'estado' => 'required|in:ACTIVO,INACTIVO',
                'estado_financiero' => 'required|in:REGULAR,DEUDOR',
                'estado_disciplinario' => 'required|in:SIN_SANCION,SANCIONADO',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Verifica si el tipo de alumno requiere código y carrera
            $tipoAlumno = TipoAlumno::find($request->id_tipo_alumno);
            if ($tipoAlumno && $tipoAlumno->nombre !== 'Particular') {
                $request->validate([
                    'id_carrera' => 'required|exists:carreras,id_carrera',
                    'codigo_estudiante' => 'required|string|max:50|unique:estudiantes,codigo_estudiante,' . $id . ',id_estudiante',
                ]);
            } else {
                // Limpiar si se pasó de tipo "regular" a "particular"
                $request->merge([
                    'id_carrera' => null,
                    'codigo_estudiante' => null,
                ]);
            }

            // Construir datos
            $datos = $request->only([
                'id_persona',
                'id_tipo_alumno',
                'id_carrera',
                'codigo_estudiante',
                'estado',
                'estado_financiero',
                'estado_disciplinario',
            ]);

            // Foto
            if ($request->hasFile('foto')) {
                if (
                    $estudiante->foto &&
                    $estudiante->foto !== 'fotos_estudiantes/estudiante.png' &&
                    Storage::disk('public')->exists($estudiante->foto)
                ) {
                    Storage::disk('public')->delete($estudiante->foto);
                }

                $datos['foto'] = $request->file('foto')->store('fotos_estudiantes', 'public');
            }

            // Validación adicional para cambio de estado según matrículas vigentes
            if ($request->estado !== $estudiante->estado) {
                $tieneMatriculaVigente = \App\Models\Matricula::where('id_estudiante', $estudiante->id_estudiante)
                    ->where('estado', 'VIGENTE')
                    ->whereNull('deleted_at')
                    ->exists();

                if ($request->estado === 'ACTIVO' && !$tieneMatriculaVigente) {
                    return redirect()->back()
                        ->withInput()
                        ->with([
                            'toast_message' => 'No puedes activar al estudiante porque no tiene matrículas vigentes.',
                            'toast_type' => 'warning'
                        ]);
                }

                if ($request->estado === 'INACTIVO' && $tieneMatriculaVigente) {
                    return redirect()->back()
                        ->withInput()
                        ->with([
                            'toast_message' => 'No puedes inactivar al estudiante porque tiene matrículas vigentes.',
                            'toast_type' => 'warning'
                        ]);
                }
            }



            $estudiante->update($datos);

            Log::info('Estudiante actualizado', [
                'usuario_id' => Auth::id(),
                'estudiante_id' => $estudiante->id_estudiante,
                'datos' => $datos,
            ]);

            session()->flash('toast_message', 'Estudiante actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            Log::error('Error al actualizar estudiante', [
                'usuario_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            session()->flash('toast_message', 'Error al actualizar estudiante.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('estudiantes');
    }



    public function destroy($id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);

            // Eliminar foto si no es la por defecto
            if (
                $estudiante->foto &&
                $estudiante->foto !== 'fotos_estudiantes/estudiante.png' &&
                Storage::disk('public')->exists($estudiante->foto)
            ) {
                Storage::disk('public')->delete($estudiante->foto);
            }

            $estudiante->delete();

            Log::warning('Estudiante eliminado', [
                'usuario_id' => Auth::id(),
                'estudiante_eliminado' => $estudiante->toArray()
            ]);

            session()->flash('toast_message', 'Estudiante eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            Log::error('Error al eliminar estudiante', [
                'usuario_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            session()->flash('toast_message', 'Error al eliminar el estudiante.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('estudiantes');
    }


    public function buscarAjax(Request $request)
    {
        $query = $request->input('query');

        $estudiantes = Estudiante::join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
            ->where(function ($q) use ($query) {
                $q->where('personas.nombres', 'like', "%{$query}%")
                    ->orWhere('personas.apellido_paterno', 'like', "%{$query}%")
                    ->orWhere('personas.apellido_materno', 'like', "%{$query}%")
                    ->orWhere('personas.documento', 'like', "%{$query}%");
            })
            ->select(
                'estudiantes.id_estudiante',
                'personas.nombres',
                'personas.apellido_paterno',
                'personas.apellido_materno',
                'personas.documento',
                'estudiantes.codigo_estudiante'
            )
            ->limit(10)
            ->get();

        return response()->json($estudiantes);
    }
}
