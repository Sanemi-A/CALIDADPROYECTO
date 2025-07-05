<?php

use App\Http\Controllers\admin\EstudiantesController;
use App\Http\Controllers\admin\PersonasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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
});
