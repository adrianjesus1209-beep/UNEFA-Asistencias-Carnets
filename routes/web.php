<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Módulo Estudiante (Reyli)
Route::prefix('dashboard/estudiante')->name('dashboard.estudiante')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/justificativos', [StudentController::class, 'storeJustification'])
        ->name('.justificativos.store');
});
