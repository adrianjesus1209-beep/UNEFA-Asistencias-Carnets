<?php

/*
|--------------------------------------------------------------------------
| Rutas web del portal UNEFA (Sistema de Asistencias y Carnetizacion)
|--------------------------------------------------------------------------
|
| Un unico dashboard parametrizado por rol y seccion (dashboard.index)
| reutiliza layout y componentes compartidos para todos los perfiles.
|
*/

use Illuminate\Support\Facades\Route;

// Raiz: redirige a la landing institucional.
Route::redirect('/', '/landing');

// Landing publica con las 5 secciones (inicio, doctrina, carreras, admisiones, servicios).
Route::get('/landing', function () {
    return view('landing.index');
})->name('landing');

// Acceso SICEU.
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Preinscripcion CINU (wizard de 3 pasos).
Route::get('/registro', function () {
    return view('auth.registro');
})->name('registro');

// Dashboard unificado por rol y seccion.
Route::get('/dashboard/{rol?}/{seccion?}', function (?string $rol = null, ?string $seccion = null) {
    $rol = request('rol', $rol ?? 'estudiante');
    $seccion = request('seccion', $seccion ?? 'inicio');

    return view('dashboard.index', compact('rol', 'seccion'));
})->whereIn('rol', ['estudiante', 'profesor', 'coordinador', 'director'])
  ->name('dashboard');
