<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class DocentesController extends Controller
{
    public function index()
    {
        return view('admin.docentes');
    }

    public function listar(Request $request)
    {
        $queryBase = DB::table('docentes')
            ->join('personas', 'docentes.id_persona', '=', 'personas.id_persona')
            ->select(
                'docentes.id_docente',
                'personas.nombres',
                'personas.apellido_paterno',
                'personas.apellido_materno',
                'personas.documento',
                'docentes.especialidad',
                'docentes.grado_academico',
                'docentes.cv_url',
                'docentes.estado',
                'docentes.foto'
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
                    ->orWhere('docentes.especialidad', 'like', "%{$search}%")
                    ->orWhere('docentes.grado_academico', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();
        $query->orderBy('docentes.id_docente', 'desc');

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
                'id_persona'       => ['required', 'exists:personas,id_persona', Rule::unique('docentes', 'id_persona')],
                'especialidad'     => 'required|string|max:100',
                'grado_academico'  => 'required|string|max:100',
                'cv_url'           => 'nullable|file|mimes:pdf|max:2048',
                'foto'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'estado'           => ['nullable', Rule::in(['ACTIVO', 'INACTIVO', 'INHABILITADO', 'SUSPENDIDO', 'RETIRADO'])],
            ]);

            // Subir CV si se proporciona
            $cvPath = $request->hasFile('cv_url')
                ? $request->file('cv_url')->store('docentes/cv', 'public')
                : null;

            // Subir Foto o usar por defecto
            $fotoPath = $request->hasFile('foto')
                ? $request->file('foto')->store('docentes/fotos', 'public')
                : 'docentes/fotos/docente.png';

            // Registrar docente
            $docente = Docente::create([
                'id_persona'       => $request->id_persona,
                'especialidad'     => $request->especialidad,
                'grado_academico'  => $request->grado_academico,
                'cv_url'           => $cvPath,
                'foto'             => $fotoPath,
                'estado'           => $request->estado ?? 'INACTIVO',
            ]);

            Log::info('Docente registrado', [
                'usuario_id' => Auth::id(),
                'docente_id' => $docente->id_docente,
            ]);

            session()->flash('toast_message', 'Docente registrado correctamente.');
            session()->flash('toast_type', 'success');
        } catch (ValidationException $e) {
            session()->flash('toast_message', 'Error de validación: ' . implode(' ', $e->validator->errors()->all()));
            session()->flash('toast_type', 'warning');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Log::error('Error al registrar docente', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error inesperado: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
            return redirect()->back()->withInput();
        }

        return redirect()->route('docentes');
    }



    public function update(Request $request, $id)
    {
        try {
            $docente = Docente::findOrFail($id);

            $request->validate([
                'especialidad'     => 'required|string|max:100',
                'grado_academico'  => 'required|string|max:100',
                'cv_url'           => 'nullable|file|mimes:pdf|max:2048',
                'foto'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'estado'           => ['nullable', Rule::in(['ACTIVO', 'INACTIVO', 'INHABILITADO', 'SUSPENDIDO', 'RETIRADO'])],
            ]);

            // Actualizar CV si se sube uno nuevo
            if ($request->hasFile('cv_url')) {
                if ($docente->cv_url && Storage::disk('public')->exists($docente->cv_url)) {
                    Storage::disk('public')->delete($docente->cv_url);
                }
                $cvPath = $request->file('cv_url')->store('docentes/cv', 'public');
            } else {
                $cvPath = $docente->cv_url;
            }

            // Actualizar foto si se sube una nueva
            if ($request->hasFile('foto')) {
                if ($docente->foto !== 'docentes/fotos/docente.png' && Storage::disk('public')->exists($docente->foto)) {
                    Storage::disk('public')->delete($docente->foto);
                }
                $fotoPath = $request->file('foto')->store('docentes/fotos', 'public');
            } else {
                $fotoPath = $docente->foto;
            }

            // Actualizar los datos del docente
            $docente->update([
                'especialidad'     => $request->especialidad,
                'grado_academico'  => $request->grado_academico,
                'cv_url'           => $cvPath,
                'foto'             => $fotoPath,
                'estado'           => $request->estado ?? 'INACTIVO',
            ]);

            Log::info('Docente actualizado', [
                'usuario_id' => Auth::id(),
                'docente_id' => $docente->id_docente,
            ]);

            session()->flash('toast_message', 'Docente actualizado correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            Log::error('Error al actualizar docente', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error al actualizar docente: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('docentes');
    }


    public function destroy($id)
    {
        try {
            $docente = Docente::findOrFail($id);

            // Eliminar archivo CV si existe
            if ($docente->cv_url && Storage::disk('public')->exists($docente->cv_url)) {
                Storage::disk('public')->delete($docente->cv_url);
            }

            // Eliminar foto si no es la predeterminada
            if (
                $docente->foto &&
                $docente->foto !== 'docentes/fotos/docente.png' &&
                Storage::disk('public')->exists($docente->foto)
            ) {
                Storage::disk('public')->delete($docente->foto);
            }

            // Eliminar el registro del docente
            $docente->delete();

            Log::info('Docente eliminado', [
                'usuario_id' => Auth::id(),
                'docente_id' => $id
            ]);

            session()->flash('toast_message', 'Docente eliminado correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            Log::error('Error al eliminar docente', ['error' => $e->getMessage()]);
            session()->flash('toast_message', 'Error al eliminar el docente.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('docentes');
    }
}
