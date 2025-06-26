<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');  
    Route::post('/login', 'login');             
    Route::post('/logout', 'logout')->name('logout'); 
});

Route::middleware('auth')->group(function () {

    Route::get('/inicio', [LoginController::class, 'mostrar'])->name('inicio');

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');

    Route::prefix('users')->name('users.')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

});
