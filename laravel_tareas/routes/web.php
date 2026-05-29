<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/tareas'));

Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('tareas', TareaController::class)->except(['show']);
    Route::patch('tareas/{tarea}/estado', [TareaController::class, 'cambiarEstado'])->name('tareas.estado');
});
