@extends('layouts.dashboard')

@section('title', 'Panel Profesor | Portal UNEFA')
@section('header-subtitle', 'Panel Profesor')

@section('content')
    {{-- Contenido tomado de la vista profesor del dashboard de UnefaApp (src/app/dashboard.tsx). --}}
    @include('partials.selector-entidad', ['activo' => 'profesor'])

    <div class="mt-4">
        @include('partials.session-banner', [
            'insignia' => 'DOCENTE ORDINARIO',
            'insigniaFondo' => 'bg-[rgba(13,148,136,0.1)]',
            'insigniaTexto' => 'text-[#0d9488]',
            'icono' => 'book-open',
            'acentoFondo' => 'bg-[#0d9488]',
            'bordeClase' => 'border-[#0d9488]',
            'nombre' => 'Prof. Ing. Elena Rivas Méndez',
            'cedula' => 'V-14.567.890',
            'departamento' => 'Dpto. de Informática y Telecomunicaciones',
            'subtitulo' => 'Dedicación Exclusiva · Escalafón Agregado',
            'matricula' => 'DOC-UNEFA-8812',
        ])

        <div class="flex flex-col gap-5">
            {{-- Resumen docente --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">3</p>
                    <p class="text-[11px] font-semibold text-slate-500">Secciones asignadas</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">89</p>
                    <p class="text-[11px] font-semibold text-slate-500">Alumnos matriculados</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-[#0d9488]">32</p>
                    <p class="text-[11px] font-semibold text-slate-500">Clases impartidas</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-green">92.8%</p>
                    <p class="text-[11px] font-semibold text-slate-500">Asistencia promedio</p>
                </div>
            </div>

            {{-- Secciones a cargo y control de asistencia --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <div class="mb-3.5 flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">CÁTEDRA ACTIVA</p>
                        <p class="text-base font-black text-slate-900">Secciones</p>
                    </div>
                    <span class="rounded-lg bg-[rgba(13,148,136,0.1)] px-2 py-1 text-[11px] font-extrabold text-[#0d9488]">Activas 2026-I</span>
                </div>

                <div class="grid gap-3 lg:grid-cols-3">
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-2 flex items-start justify-between gap-2">
                            <div>
                                <p class="text-[11px] font-extrabold uppercase text-[#0d9488]">Sección SIS-701</p>
                                <p class="text-[15px] font-black text-slate-900">Sistemas Distribuidos</p>
                            </div>
                            <span class="flex flex-col items-center rounded-[10px] bg-[rgba(13,148,136,0.1)] px-2 py-1">
                                <span class="text-[13px] font-black text-[#0d9488]">93.4%</span>
                                <span class="text-[9px] font-bold text-[#0d9488]">Asistencia</span>
                            </span>
                        </div>

                        <div class="mb-3 flex flex-wrap gap-x-2.5 gap-y-1">
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'users', 'clase' => 'h-3 w-3 text-slate-400'])
                                32 estudiantes
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                Lun y Mié 08:00 - 10:15
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'map-pin', 'clase' => 'h-3 w-3 text-slate-400'])
                                Lab Telemática 2
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2 border-t border-slate-200 pt-2.5">
                            <button type="button" data-abrir-qr class="flex flex-1 items-center justify-center gap-1.5 rounded-[10px] bg-unefa-blue px-3 py-2 text-xs font-extrabold text-white transition hover:brightness-110">
                                @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-3.5 w-3.5 text-white'])
                                Escanear Asistencia QR
                            </button>
                            <span class="flex items-center justify-center rounded-[10px] border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700">
                                Ver Planilla
                            </span>
                        </div>
                        <p class="mt-2 text-[10px] font-semibold text-slate-400">Pase de lista al día</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-2 flex items-start justify-between gap-2">
                            <div>
                                <p class="text-[11px] font-extrabold uppercase text-[#0d9488]">Sección SIS-702</p>
                                <p class="text-[15px] font-black text-slate-900">Arquitectura de Software</p>
                            </div>
                            <span class="flex flex-col items-center rounded-[10px] bg-[rgba(13,148,136,0.1)] px-2 py-1">
                                <span class="text-[13px] font-black text-[#0d9488]">89.1%</span>
                                <span class="text-[9px] font-bold text-[#0d9488]">Asistencia</span>
                            </span>
                        </div>

                        <div class="mb-3 flex flex-wrap gap-x-2.5 gap-y-1">
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'users', 'clase' => 'h-3 w-3 text-slate-400'])
                                28 estudiantes
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                Mar y Jue 10:30 - 12:45
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'map-pin', 'clase' => 'h-3 w-3 text-slate-400'])
                                Aula B-12
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2 border-t border-slate-200 pt-2.5">
                            <button type="button" data-abrir-qr class="flex flex-1 items-center justify-center gap-1.5 rounded-[10px] bg-unefa-blue px-3 py-2 text-xs font-extrabold text-white transition hover:brightness-110">
                                @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-3.5 w-3.5 text-white'])
                                Escanear Asistencia QR
                            </button>
                            <span class="flex items-center justify-center rounded-[10px] border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700">
                                Ver Planilla
                            </span>
                        </div>
                        <p class="mt-2 text-[10px] font-semibold text-slate-400">Pase de lista al día</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-2 flex items-start justify-between gap-2">
                            <div>
                                <p class="text-[11px] font-extrabold uppercase text-[#0d9488]">Sección PRY-501</p>
                                <p class="text-[15px] font-black text-slate-900">Proyecto Sociotecnológico I</p>
                            </div>
                            <span class="flex flex-col items-center rounded-[10px] bg-[rgba(13,148,136,0.1)] px-2 py-1">
                                <span class="text-[13px] font-black text-[#0d9488]">95.8%</span>
                                <span class="text-[9px] font-bold text-[#0d9488]">Asistencia</span>
                            </span>
                        </div>

                        <div class="mb-3 flex flex-wrap gap-x-2.5 gap-y-1">
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'users', 'clase' => 'h-3 w-3 text-slate-400'])
                                29 estudiantes
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                Viernes 08:00 - 11:30
                            </span>
                            <span class="flex items-center gap-1 text-[11px] font-semibold text-slate-500">
                                @include('partials.icon', ['name' => 'map-pin', 'clase' => 'h-3 w-3 text-slate-400'])
                                Aula A-05
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-2 border-t border-slate-200 pt-2.5">
                            <button type="button" data-abrir-qr class="flex flex-1 items-center justify-center gap-1.5 rounded-[10px] bg-unefa-blue px-3 py-2 text-xs font-extrabold text-white transition hover:brightness-110">
                                @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-3.5 w-3.5 text-white'])
                                Escanear Asistencia QR
                            </button>
                            <span class="flex items-center justify-center rounded-[10px] border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700">
                                Ver Planilla
                            </span>
                        </div>
                        <p class="mt-2 text-[10px] font-semibold text-slate-400">Pase de lista al día</p>
                    </div>
                </div>
            </div>

            {{-- Herramientas del docente --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">GESTIÓN ACADÉMICA DOCENTE</p>
                <p class="text-base font-black text-slate-900">Operaciones de cátedra</p>

                <div class="mt-2.5 grid gap-2.5 lg:grid-cols-3">
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        @include('partials.icon', ['name' => 'award', 'clase' => 'h-5 w-5 shrink-0 text-[#0d9488]'])
                        <div>
                            <p class="text-[13px] font-extrabold text-slate-900">Cargar Calificaciones 1er Corte</p>
                            <p class="text-[11px] text-slate-500">Plazo de consignación abierto hasta la semana 6</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        @include('partials.icon', ['name' => 'users', 'clase' => 'h-5 w-5 shrink-0 text-unefa-blue'])
                        <div>
                            <p class="text-[13px] font-extrabold text-slate-900">Reportar Inasistencias Críticas</p>
                            <p class="text-[11px] text-slate-500">Notificación preventiva a la Coordinación de Carrera</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        @include('partials.icon', ['name' => 'calendar', 'clase' => 'h-5 w-5 shrink-0 text-unefa-goldDark'])
                        <div>
                            <p class="text-[13px] font-extrabold text-slate-900">Planificación Semestral Consolidada</p>
                            <p class="text-[11px] text-slate-500">Cronograma de evaluaciones, talleres y defensas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Retorno al inicio de sesion --}}
        <div class="mb-2 mt-4 flex justify-center">
            <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-xl border border-slate-300 bg-slate-100 px-5 py-3 text-[13px] font-extrabold text-unefa-navy transition hover:bg-slate-200">
                @include('partials.icon', ['name' => 'arrow-left', 'clase' => 'h-4 w-4 text-unefa-navy'])
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection
