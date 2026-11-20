@extends('layouts.dashboard')

@section('title', 'Panel Estudiante | Portal UNEFA')
@section('header-subtitle', 'Panel Estudiante')

@section('content')
    {{-- Contenido tomado de la vista estudiante del dashboard de UnefaApp (src/app/dashboard.tsx). --}}
    @include('partials.selector-entidad', ['activo' => 'estudiante'])

    <div class="mt-4">
        @include('partials.session-banner', [
            'insignia' => 'ESTUDIANTE REGULAR',
            'insigniaFondo' => 'bg-[rgba(4,15,217,0.08)]',
            'insigniaTexto' => 'text-unefa-blue',
            'icono' => 'graduation-cap',
            'acentoFondo' => 'bg-unefa-blue',
            'bordeClase' => 'border-unefa-blue',
            'nombre' => 'Carlos Manuel Mendoza Rojas',
            'cedula' => 'V-28.123.456',
            'departamento' => 'Ingeniería de Sistemas · 7mo Semestre',
            'subtitulo' => 'Matrícula Oficial 2026-I · Modalidad Diurna',
            'matricula' => 'UNEFA-2022-04921',
        ])

        <div class="flex flex-col gap-5">
            {{-- Carnet digital simulado --}}
            <div class="rounded-[18px] border border-[rgba(242,184,7,0.4)] bg-unefa-navy p-4">
                <div class="mb-3.5 flex items-start justify-between border-b border-white/15 pb-2.5">
                    <div>
                        <p class="text-[8px] font-extrabold tracking-[0.4px] text-slate-300">REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
                        <p class="text-[7px] tracking-[0.3px] text-slate-400">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</p>
                        <p class="mt-0.5 text-[11px] font-black tracking-[0.5px] text-unefa-gold">UNEFA · CARNET DE ASISTENCIA DIGITAL</p>
                    </div>
                    <span class="rounded-md bg-unefa-gold px-2 py-[3px] text-[11px] font-black text-unefa-navy">2026-I</span>
                </div>

                <div class="flex flex-col gap-3.5 sm:flex-row sm:items-start">
                    <div class="mx-auto flex h-24 w-[78px] shrink-0 flex-col items-center justify-center gap-1 rounded-[10px] border-2 border-unefa-gold bg-white p-1 sm:mx-0">
                        @include('partials.icon', ['name' => 'user', 'clase' => 'h-9 w-9 text-slate-400'])
                        <span class="text-center text-[8px] font-extrabold text-slate-500">FOTO ESTUDIANTE</span>
                    </div>

                    <div class="flex-1">
                        <p class="mb-0.5 text-[13px] font-black text-white">Carlos Manuel Mendoza Rojas</p>
                        <p class="mb-0.5 text-xs font-extrabold text-unefa-gold">V-28.123.456</p>
                        <p class="mb-0.5 text-[10px] font-bold text-slate-300">INGENIERÍA DE SISTEMAS</p>
                        <p class="mb-2 text-[9px] font-extrabold text-emerald-400">CONDICIÓN: REGULAR ACTIVO</p>

                        <div class="flex items-center gap-2 rounded-lg bg-white p-1">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center">
                                @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-10 w-10 text-unefa-navy'])
                            </span>
                            <span>
                                <span class="block font-mono text-[10px] font-bold tracking-[2px] text-slate-900">||| | |||| || ||| |||| | |||</span>
                                <span class="block font-mono text-[8px] font-bold text-slate-500">MAT: 2022-04921-UNEF</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metricas del estudiante --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">7mo</p>
                    <p class="text-[11px] font-semibold text-slate-500">Semestre en curso</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">6</p>
                    <p class="text-[11px] font-semibold text-slate-500">Materias inscritas</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-blue">17.42</p>
                    <p class="text-[11px] font-semibold text-slate-500">Promedio general</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-green">94.5%</p>
                    <p class="text-[11px] font-semibold text-slate-500">Asistencia global</p>
                </div>
            </div>

            {{-- Modulo: Asignaturas y control de asistencias --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <div class="mb-3.5 flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">CONTROL DE ASISTENCIAS</p>
                        <p class="text-base font-black text-slate-900">Mis asignaturas inscritas</p>
                    </div>
                    <span class="flex items-center gap-1 rounded-lg bg-green-100 px-2 py-1">
                        @include('partials.icon', ['name' => 'circle-check-big', 'clase' => 'h-3 w-3 text-unefa-green'])
                        <span class="text-[11px] font-extrabold text-unefa-green">Solvente</span>
                    </span>
                </div>

                <div class="grid gap-2.5 lg:grid-cols-2">
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex items-center justify-between">
                            <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[10px] font-extrabold text-slate-700">SIS-701</span>
                            <span class="rounded-full bg-[rgba(4,15,217,0.1)] px-2 py-0.5 text-[11px] font-black text-unefa-blue">96%</span>
                        </div>
                        <p class="mb-0.5 text-sm font-extrabold text-slate-900">Sistemas Distribuidos</p>
                        <p class="mb-2 text-xs text-slate-500">Prof. Elena Rivas Méndez</p>
                        <div class="flex items-center justify-between border-t border-slate-200 pt-2">
                            <span class="flex items-center gap-1">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                <span class="text-[11px] font-semibold text-slate-500">Lab Telemática 2</span>
                            </span>
                            <span class="text-[11px] font-bold text-unefa-blue">24/25 asistidas</span>
                        </div>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex items-center justify-between">
                            <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[10px] font-extrabold text-slate-700">CIB-702</span>
                            <span class="rounded-full bg-[rgba(4,15,217,0.1)] px-2 py-0.5 text-[11px] font-black text-unefa-blue">100%</span>
                        </div>
                        <p class="mb-0.5 text-sm font-extrabold text-slate-900">Ciberseguridad y Soberanía Nacional</p>
                        <p class="mb-2 text-xs text-slate-500">Prof. Carlos Morales</p>
                        <div class="flex items-center justify-between border-t border-slate-200 pt-2">
                            <span class="flex items-center gap-1">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                <span class="text-[11px] font-semibold text-slate-500">Aula A-04</span>
                            </span>
                            <span class="text-[11px] font-bold text-unefa-blue">20/20 asistidas</span>
                        </div>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex items-center justify-between">
                            <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[10px] font-extrabold text-slate-700">TEL-703</span>
                            <span class="rounded-full bg-[rgba(4,15,217,0.1)] px-2 py-0.5 text-[11px] font-black text-unefa-blue">88%</span>
                        </div>
                        <p class="mb-0.5 text-sm font-extrabold text-slate-900">Redes de Computadoras II</p>
                        <p class="mb-2 text-xs text-slate-500">Prof. Luis Sánchez</p>
                        <div class="flex items-center justify-between border-t border-slate-200 pt-2">
                            <span class="flex items-center gap-1">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                <span class="text-[11px] font-semibold text-slate-500">Aula C-10</span>
                            </span>
                            <span class="text-[11px] font-bold text-unefa-blue">22/25 asistidas</span>
                        </div>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex items-center justify-between">
                            <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[10px] font-extrabold text-slate-700">PRY-704</span>
                            <span class="rounded-full bg-[rgba(4,15,217,0.1)] px-2 py-0.5 text-[11px] font-black text-unefa-blue">95%</span>
                        </div>
                        <p class="mb-0.5 text-sm font-extrabold text-slate-900">Metodología y Proyecto Especial</p>
                        <p class="mb-2 text-xs text-slate-500">Prof. Carmen Gómez</p>
                        <div class="flex items-center justify-between border-t border-slate-200 pt-2">
                            <span class="flex items-center gap-1">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                <span class="text-[11px] font-semibold text-slate-500">Aula A-02</span>
                            </span>
                            <span class="text-[11px] font-bold text-unefa-blue">19/20 asistidas</span>
                        </div>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex items-center justify-between">
                            <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[10px] font-extrabold text-slate-700">SOF-705</span>
                            <span class="rounded-full bg-[rgba(4,15,217,0.1)] px-2 py-0.5 text-[11px] font-black text-unefa-blue">92%</span>
                        </div>
                        <p class="mb-0.5 text-sm font-extrabold text-slate-900">Ingeniería de Software Crítico</p>
                        <p class="mb-2 text-xs text-slate-500">Dr. Marcos Peña</p>
                        <div class="flex items-center justify-between border-t border-slate-200 pt-2">
                            <span class="flex items-center gap-1">
                                @include('partials.icon', ['name' => 'clock', 'clase' => 'h-3 w-3 text-slate-400'])
                                <span class="text-[11px] font-semibold text-slate-500">Lab 3</span>
                            </span>
                            <span class="text-[11px] font-bold text-unefa-blue">23/25 asistidas</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tramites y constancias --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">TRÁMITES Y CONSTANCIAS</p>
                <p class="text-base font-black text-slate-900">Servicios digitales disponibles</p>

                <div class="mt-2.5 grid gap-2 lg:grid-cols-2">
                    <div class="flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div>
                            <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Constancia de Estudio</p>
                            <p class="text-[11px] leading-4 text-slate-500">Descarga inmediata con firma digital y sello QR</p>
                        </div>
                        @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-unefa-blue'])
                    </div>
                    <div class="flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div>
                            <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Récord de Calificaciones</p>
                            <p class="text-[11px] leading-4 text-slate-500">Historial acumulado y promedio ponderado</p>
                        </div>
                        @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-unefa-blue'])
                    </div>
                    <div class="flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div>
                            <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Horario Semanal 2026-I</p>
                            <p class="text-[11px] leading-4 text-slate-500">Distribución de bloques por aula y laboratorio</p>
                        </div>
                        @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-unefa-blue'])
                    </div>
                    <div class="flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div>
                            <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Justificar Inasistencia</p>
                            <p class="text-[11px] leading-4 text-slate-500">Consignación digital de justificativo médico/laboral</p>
                        </div>
                        @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-unefa-blue'])
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
