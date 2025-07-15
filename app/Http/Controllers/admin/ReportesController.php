<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function cantidadEstudiantesActivos()
    {
        $cantidad = Estudiante::where('estado', 'ACTIVO')->count();

        return response()->json([
            'cantidad_activos' => $cantidad
        ]);
    }

    public function cantidadCursos()
    {
        $cantidad = \App\Models\Curso::count();

        return response()->json([
            'cantidad_cursos' => $cantidad
        ]);
    }
}
