<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluacionesController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\PlanEntrenamientosController;
use App\Http\Controllers\PlanEjerciciosController;


// Ruta de bienvenida
Route::get('/', function (){
    return view('welcome');
})->name('welcome');

// Grupo de rutas protegidas por autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function (){
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        

    // Plan de entrenamiento
    Route::prefix('planEntrenamiento')->group(function (){
        Route::get('/', [PlanEntrenamientosController::class, 'index'])->name('planesEntrenamiento.index');
        Route::post('generar', [PlanEntrenamientosController::class, 'generarPlan'])->name('planEntrenamiento.generar');
        Route::get('{dia}', [PlanEntrenamientosController::class, 'mostrarPlan'])->name('planEntrenamiento.mostrar');
        Route::post('completar', [PlanEntrenamientosController::class, 'completarPlan'])->name('planEntrenamiento.completar');
        Route::post('completar-dia', [PlanEntrenamientosController::class, 'completarDia'])->name('planEntrenamiento.completar-dia');
        Route::get('/planEntrenamiento/pdf', [PlanEntrenamientosController::class, 'descargarPDF'])->name('planEntrenamiento.pdf');
    });
    
    // Evaluaciones
    Route::resource('evaluaciones', EvaluacionesController::class);


    // Ejercicios    
    Route::post('/plan-ejercicios/actualizar-estado/{id}', [PlanEjerciciosController::class, 'actualizarEstado'])->name('planEjercicios.actualizar');
    Route::resource('ejercicios', EjercicioController::class);
    
    //Rocodromos
    Route::resource('rocodromos', App\Http\Controllers\RocodromoController::class);

    // Configuración de administrador
    Route::get('/admin/settings', function (){
        return view('admin.settings');
    })->name('admin.settings');
    
    // Perfil de Usuario
    Route::get('/user/profile', function (){
        return view('profile.show');
    })->name('profile.show');

     // Cambiar Contraseña    
    Route::get('/user/change-password', function (){
        return view('profile.update-password-form');
    })->name('profile.change-password');

    // Mostrar formulario de borrado de cuenta
    Route::delete('/user/manual-delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.manual-delete');
});