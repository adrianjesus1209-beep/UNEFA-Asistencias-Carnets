<?php

use Illuminate\Support\Facades\Route;

// landing publica //
Route::get('/', function () {
    return view('landing.index');
})->name('landing');

// autenticación //
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
})->name('login.post');

// registro //
Route::get('/registro', function () {
    return view('auth.registro');
})->name('registro');

Route::post('/registro', function () {

})->name('registro.post');

// dashboards por rol //
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    
    // estudiante // 
    Route::get('/estudiante', function () {
        return view('dashboard.student');
    })->name('estudiante');

    // profesor //
    Route::get('/profesor', function () {
        return view('dashboard.teacher');
    })->name('profesor');

    // coordinador //
    Route::get('/coordinador', function () {
        return view('dashboard.coordinator');
    })->name('coordinador');

    // director //
    Route::get('/director', function () {
        return view('dashboard.director');
    })->name('director');
});