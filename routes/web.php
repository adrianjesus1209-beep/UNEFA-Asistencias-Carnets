<?php

use App\Http\Controllers\DirectorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', LoginController::class)->name('login.post');

    Route::get('/registro', function () {
        return view('auth.registro');
    })->name('registro');

    Route::post('/registro', function () {
    })->name('registro.post');
});

Route::middleware(['auth', 'active.user'])->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::middleware('role:Teacher,Super Administrator')
            ->get('/profesor', fn () => view('dashboard.teacher'))
            ->name('profesor');

        Route::middleware('role:Academic Coordinator,Super Administrator')
            ->get('/coordinador', fn () => view('dashboard.coordinator'))
            ->name('coordinador');

        Route::middleware('role:Director,Super Administrator')
            ->group(function () {
                Route::get('/director', [DirectorController::class, 'index'])
                    ->name('director');
                Route::post('/director/coordinadores', [DirectorController::class, 'assignCoordinator'])
                    ->name('director.coordinadores.assign');
            });
    });

    Route::middleware('role:Student,Super Administrator')
        ->prefix('dashboard/estudiante')
        ->name('dashboard.estudiante')
        ->group(function () {
            Route::get('/', [StudentController::class, 'index']);
            Route::post('/justificativos', [StudentController::class, 'storeJustification'])
                ->name('.justificativos.store');
        });
});