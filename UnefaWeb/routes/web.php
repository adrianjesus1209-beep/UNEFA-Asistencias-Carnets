<?php

/*
|--------------------------------------------------------------------------
| Rutas web del portal UNEFA (Sistema de Asistencias y Carnetizacion)
|--------------------------------------------------------------------------
|
| Estructura estilo Laravel; el router propio del backend nativo debe
| registrarlas y resolver cada vista Blade. Solo se migraron las vistas
| con equivalencia directa en UnefaApp; el resto de vistas antiguas fue
| eliminada.
|
| TODO(backend): activar la autenticacion real de SICEU y reemplazar las
| rutas de simulacion por roles por el dashboard derivado de la sesion.
|
*/

use Illuminate\Support\Facades\Route;

// Raiz: redirige a la landing institucional.
Route::redirect('/', '/landing');

// Landing publica con las 5 secciones (inicio, doctrina, carreras, admisiones, servicios).
Route::get('/landing', function () {
    return view('landing.index');
})->name('landing');

// Acceso SICEU (mock con botones de simulacion por rol hasta integrar el backend).
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Preinscripcion CINU (wizard de 3 pasos).
Route::get('/registro', function () {
    return view('auth.registro');
})->name('registro');

// Dashboards por rol (una vista por entidad; el backend debe derivar el rol de la sesion).
Route::get('/dashboard/estudiante', function () {
    return view('dashboard.student');
})->name('dashboard.estudiante');

Route::get('/dashboard/profesor', function () {
    return view('dashboard.teacher');
})->name('dashboard.profesor');

Route::get('/dashboard/coordinador', function () {
    return view('dashboard.coordinator');
})->name('dashboard.coordinador');

Route::get('/dashboard/director', function () {
    return view('dashboard.director');
})->name('dashboard.director');
