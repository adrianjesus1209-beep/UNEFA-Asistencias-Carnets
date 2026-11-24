<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Landing publica
Route::get('/', function () {
    return view('landing.index');
})->name('landing');

// Autenticacion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
})->name('login.post');

// Registro
Route::get('/registro', function () {
    return view('auth.registro');
})->name('registro');

Route::post('/registro', function () {
})->name('registro.post');

// Dashboards por rol
Route::prefix('dashboard')->name('dashboard.')->group(function () {

    // Profesor
    Route::get('/profesor', function () {
        return view('dashboard.teacher');
    })->name('profesor');

    // Coordinador
    Route::get('/coordinador', function () {
        return view('dashboard.coordinator');
    })->name('coordinador');

    // Director
    Route::get('/director', function () {
        return view('dashboard.director');
    })->name('director');
});

// Modulo Estudiante (Reyli)
Route::prefix('dashboard/estudiante')->name('dashboard.estudiante')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/justificativos', [StudentController::class, 'storeJustification'])
        ->name('.justificativos.store');
});

