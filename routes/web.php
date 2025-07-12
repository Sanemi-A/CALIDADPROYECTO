<?php

use App\Http\Controllers\admin\ContratoDocenteController;
use App\Http\Controllers\admin\CursosHorariosController;
use App\Http\Controllers\admin\CursosController;
use App\Http\Controllers\admin\EstudiantesController;
use App\Http\Controllers\admin\PersonasController;
use App\Http\Controllers\admin\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\DocentesController;
use App\Http\Controllers\admin\MatriculasController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function () {

    Route::get('/inicio', [LoginController::class, 'mostrar'])->name('inicio');

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');

    Route::get('/personas', [PersonasController::class, 'index'])->name('personas');

    Route::get('/estudiantes', [EstudiantesController::class, 'index'])->name('estudiantes');

    Route::get('/cursos', [CursosController::class, 'index'])->name('cursos');

    Route::get('/docentes', [DocentesController::class, 'index'])->name('docentes');

    Route::get('/cursos_horarios', [CursosHorariosController::class, 'index'])->name('cursos_horarios');

    Route::get('/contratos_docentes', [ContratoDocenteController::class, 'index'])->name('contratos_docentes');

    Route::get('/matriculas', [MatriculasController::class, 'index'])->name('matriculas');

    Route::controller(RolesController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles');
        Route::post('/roles', 'store')->name('roles.store');
        Route::put('/roles/{id}', 'update')->name('roles.update');
        Route::delete('/roles/{id}', 'destroy')->name('roles.destroy');
    });

    // Grupo de rutas para usuarios
    Route::prefix('users')->name('users.')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::put('/{id}/password', [UserController::class, 'updatePassword'])->name('updatePassword');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('personas')->name('personas.')->group(function () {
        Route::get('/listar', [PersonasController::class, 'listar'])->name('listar');
        Route::get('/buscar', [PersonasController::class, 'buscarAjax'])->name('buscar');
        Route::post('/', [PersonasController::class, 'store'])->name('store');
        Route::put('/{id}', [PersonasController::class, 'update'])->name('update');
        Route::delete('/{id}', [PersonasController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('estudiantes')->name('estudiantes.')->group(function () {
        Route::get('/listar', [EstudiantesController::class, 'listar'])->name('listar');
        Route::get('/buscar', [EstudiantesController::class, 'buscarAjax'])->name('buscar');
        Route::post('/', [EstudiantesController::class, 'store'])->name('store');
        Route::put('/{id}', [EstudiantesController::class, 'update'])->name('update');
        Route::delete('/{id}', [EstudiantesController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cursos')->name('cursos.')->group(function () {
        Route::post('/', [CursosController::class, 'store'])->name('store');
        Route::put('/{id}', [CursosController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursosController::class, 'destroy'])->name('destroy');
        Route::get('/buscar', [CursosController::class, 'buscarAjax'])->name('buscar');
    });

    Route::prefix('docentes')->name('docentes.')->group(function () {
        Route::get('/listar', [DocentesController::class, 'listar'])->name('listar');
        Route::get('/buscar', [DocentesController::class, 'buscarAjax'])->name('buscar');
        Route::post('/', [DocentesController::class, 'store'])->name('store');
        Route::put('/{id}', [DocentesController::class, 'update'])->name('update');
        Route::delete('/{id}', [DocentesController::class, 'destroy'])->name('destroy');
    });
    //fataaaaaaaaaaaaaaaaaaaaaa asignar los dias
    Route::prefix('curso-horarios')->name('curso_horarios.')->group(function () {
        Route::get('/listar', [CursosHorariosController::class, 'listar'])->name('listar');
        Route::post('/', [CursosHorariosController::class, 'store'])->name('store');
        Route::put('/{id}', [CursosHorariosController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursosHorariosController::class, 'destroy'])->name('destroy');
        Route::post('/actualizar-dias', [CursosHorariosController::class, 'actualizarDias'])->name('actualizar_dias');
    });

    Route::prefix('contratos-docentes')->name('contratos_docentes.')->group(function () {
        Route::get('/listar', [ContratoDocenteController::class, 'listar'])->name('listar');
        Route::post('/', [ContratoDocenteController::class, 'store'])->name('store');
        Route::put('/{id}', [ContratoDocenteController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContratoDocenteController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('matriculas')->name('matriculas.')->group(function () {
        Route::get('/listar', [MatriculasController::class, 'listar'])->name('listar'); 
        Route::post('/', [MatriculasController::class, 'store'])->name('store'); 
        Route::put('/{id}', [MatriculasController::class, 'update'])->name('update');

        Route::delete('/{id}', [MatriculasController::class, 'destroy'])->name('destroy');  
    });
});
