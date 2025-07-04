<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PersonasController extends Controller
{
    public function index()
    {
        return view('admin.personas');
    }
    public function listar(Request $request)
    {
        // Consulta base
        $queryBase = DB::table('personas');

        $totalRecords = $queryBase->count();

        // Clonar para filtros
        $query = clone $queryBase;

        // Filtro por búsqueda global
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('apellido_materno', 'like', "%{$search}%")
                    ->orWhere('documento', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%")
                    ->orWhere('celular', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        // Ordenamiento
        if ($request->has('order')) {
            $columnIndex = $request->input('order')[0]['column'];
            $columnName = $request->input('columns')[$columnIndex]['data'];
            $columnOrder = $request->input('order')[0]['dir'];

            if (in_array($columnName, ['nombres', 'apellido_paterno', 'documento', 'edad', 'correo'])) {
                $query->orderBy($columnName, $columnOrder);
            }
        } else {
            $query->orderBy('id_persona', 'desc');
        }

        // Paginación
        $data = $query
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
                'tipo_documento' => 'required|in:DNI,RUC,LM,CE,PAS',
                'documento' => 'required|string|max:20|unique:personas,documento',
                'nombres' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
                'celular' => 'nullable|string|max:20',
                'correo' => 'nullable|email|max:100',
                'direccion' => 'nullable|string|max:255',
                'genero' => 'required|in:M,F',
                'edad' => 'required|integer|min:0|max:120',
            ]);

            $datos = $request->only([
                'tipo_documento',
                'documento',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'celular',
                'correo',
                'direccion',
                'genero',
                'edad'
            ]);

            // Convertir campos a mayúsculas o minúsculas
            $datos['tipo_documento'] = strtoupper($datos['tipo_documento']);
            $datos['documento'] = strtoupper($datos['documento']);
            $datos['nombres'] = strtoupper($datos['nombres']);
            $datos['apellido_paterno'] = strtoupper($datos['apellido_paterno']);
            $datos['apellido_materno'] = strtoupper($datos['apellido_materno']);
            $datos['direccion'] = strtoupper($datos['direccion'] ?? '');
            $datos['correo'] = strtolower($datos['correo'] ?? '');

            $persona = Persona::create($datos);

            $user = Auth::user();

            Log::info('Persona registrada', [
                'usuario_id' => $user->id,
                'usuario_nombre' => $user->nombres . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno,
                'persona_id' => $persona->id_persona,
                'datos_persona' => $persona->toArray()
            ]);

            session()->flash('toast_message', 'Persona registrada correctamente.');
            session()->flash('toast_type', 'success');
        } catch (\Exception $e) {
            Log::error('Error al registrar persona', [
                'usuario_id' => Auth::id(),
                'error' => $e->getMessage(),
                'entrada' => $request->all()
            ]);

            session()->flash('toast_message', 'Error al registrar la persona.');
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('personas');
    }

    public function update(Request $request, $id)
    {
        try {
            $persona = Persona::findOrFail($id);

            $request->validate([
                'tipo_documento' => 'required|in:DNI,RUC,LM,CE,PAS',
                'documento' => 'required|string|max:20|unique:personas,documento,' . $id . ',id_persona',
                'nombres' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
                'celular' => 'nullable|regex:/^\d{6,20}$/',
                'correo' => 'nullable|email|max:100',
                'direccion' => 'nullable|string|max:255',
                'genero' => 'required|in:M,F',
                'edad' => 'required|integer|min:0|max:120',
            ]);

            $campos = [
                'tipo_documento',
                'documento',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'celular',
                'correo',
                'direccion',
                'genero',
                'edad'
            ];

            $datos = [];
            foreach ($campos as $campo) {
                $valor = $request->input($campo);
                $datos[$campo] = in_array($campo, ['correo']) ? strtolower($valor) : strtoupper($valor);
            }

            $persona->update($datos);

            $usuario = Auth::user();

            Log::info('Persona actualizada', [
                'usuario_id' => $usuario->id,
                'usuario_nombre' => $usuario->nombres . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno,
                'persona_id' => $persona->id_persona,
                'datos_actualizados' => $persona->toArray()
            ]);

            session()->flash('toast_message', 'Persona actualizada correctamente.');
            session()->flash('toast_type', 'info');
        } catch (\Exception $e) {
            Log::error('Error al actualizar persona', [
                'usuario_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            session()->flash('toast_message', 'Error al actualizar: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('personas');
    }
    public function buscarAjax(Request $request)
    {
        $query = $request->input('query');

        $personas = Persona::where(function ($q) use ($query) {
            $q->where('nombres', 'like', "%{$query}%")
                ->orWhere('apellido_paterno', 'like', "%{$query}%")
                ->orWhere('apellido_materno', 'like', "%{$query}%")
                ->orWhere('documento', 'like', "%{$query}%");
        })
            ->select('id_persona', 'nombres', 'apellido_paterno', 'apellido_materno', 'documento', 'correo')
            ->limit(10)
            ->get();

        return response()->json($personas);
    }


    public function destroy($id)
    {
        try {
            $persona = Persona::findOrFail($id);
            $persona->delete();

            $usuario = Auth::user();

            Log::warning('Persona eliminada', [
                'usuario_id' => $usuario->id,
                'usuario_nombre' => $usuario->nombres . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno,
                'persona_eliminada' => $persona->toArray()
            ]);

            session()->flash('toast_message', 'Persona eliminada correctamente.');
            session()->flash('toast_type', 'warning');
        } catch (\Exception $e) {
            Log::error('Error al eliminar persona', [
                'usuario_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            session()->flash('toast_message', 'Error al eliminar la persona: ' . $e->getMessage());
            session()->flash('toast_type', 'error');
        }

        return redirect()->route('personas');
    }
}
