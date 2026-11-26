@extends('layouts.dashboard')

@section('title', 'Panel Coordinador | Portal UNEFA')
@section('header-subtitle', 'Panel Coordinador')

@section('content')
    @php
        $banner = $bannerData ?? [];
        $stats = $metrics ?? [];
        $totalSections = (int) ($stats['sections'] ?? 0);
        $totalTeachers = (int) ($stats['teachers'] ?? 0);
        $pendingCount = (int) ($stats['pending_count'] ?? 0);
    @endphp

    <div class="mt-4">
        @include('partials.session-banner', [
            'insignia' => 'COORDINACIÓN DE CARRERA',
            'insigniaFondo' => 'bg-[rgba(180,83,9,0.1)]',
            'insigniaTexto' => 'text-[#b45309]',
            'icono' => 'clipboard-check',
            'acentoFondo' => 'bg-[#b45309]',
            'bordeClase' => 'border-[#b45309]',
            'nombre' => $banner['nombre'] ?? 'Coordinador Académico',
            'cedula' => $banner['cedula'] ?? 'V-00000000',
            'departamento' => $banner['departamento'] ?? 'Coordinación de Carrera',
            'subtitulo' => $banner['subtitulo'] ?? 'Decanato Académico',
            'matricula' => $banner['matricula'] ?? 'COORD-2026',
        ])

        <div class="flex flex-col gap-5">
            {{-- Métricas de coordinación --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">{{ $stats['students'] ?? 0 }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Matrícula carrera</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">{{ $totalTeachers }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Docentes adscritos</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-[#b45309]">{{ $totalSections }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Secciones activas</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-green">{{ $stats['attendance_rate'] ?? '0.0%' }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Asistencia global</p>
                </div>
            </div>

            {{-- Módulo de supervisión en tiempo real --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <div class="mb-3.5 flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">SUPERVISIÓN DE CARRERA</p>
                        <p class="text-base font-black text-slate-900">Cátedras y docentes</p>
                    </div>
                    <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-1 text-[11px] font-extrabold text-[#b45309]">
                        {{ $career->career_code ?? 'Carrera' }} · Activo
                    </span>
                </div>

                <div class="grid gap-2.5 lg:grid-cols-2">
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Asistencia de docentes</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">
                                {{ $stats['attendance_rate'] ?? '0.0%' }} Asistencia
                            </span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">{{ $totalTeachers }} docentes adscritos</p>
                        <p class="text-[11px] leading-4 text-slate-500">Registro validado en cátedras activas de la carrera.</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Solicitudes de Inscripción</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">
                                {{ $pendingCount > 0 ? 'Atención requerida' : 'Al día' }}
                            </span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">{{ $pendingCount }} solicitudes pendientes</p>
                        <p class="text-[11px] leading-4 text-slate-500">Inscripciones y cambios de sección por validar en coordinación.</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Secciones en Curso</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">
                                {{ isset($sections) ? $sections->count() : $totalSections }} registradas
                            </span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">{{ $totalSections }} secciones activas</p>
                        <p class="text-[11px] leading-4 text-slate-500">Control de apertura y seguimiento del período académico.</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Matrícula Estudiantil</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">Consolidado</span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">{{ $stats['students'] ?? 0 }} estudiantes activos</p>
                        <p class="text-[11px] leading-4 text-slate-500">Población estudiantil adscrita a {{ $career->career_name ?? 'la carrera' }}.</p>
                    </div>
                </div>
            </div>

            {{-- Acciones de coordinación --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">GESTIÓN DEPARTAMENTAL</p>
                <p class="text-base font-black text-slate-900">Acciones de carrera</p>

                <div class="mt-2.5 grid gap-2 lg:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Asignación de Carga Académica</p>
                        <p class="text-[11px] leading-4 text-slate-500">Distribución de horas docentes y aprobación de horarios</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Validación de Jurados de Grado</p>
                        <p class="text-[11px] leading-4 text-slate-500">Aprobación de Trabajos Especiales de Grado (TEG)</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Solicitudes de Cambio de Sección</p>
                        <p class="text-[11px] leading-4 text-slate-500">{{ $pendingCount }} solicitudes pendientes por cupo y compatibilidad</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Reporte al Decanato Académico</p>
                        <p class="text-[11px] leading-4 text-slate-500">Informe mensual de rendimiento y retención estudiantil</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Retorno al inicio de sesión --}}
        <div class="mb-2 mt-4 flex justify-center">
            <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-xl border border-slate-300 bg-slate-100 px-5 py-3 text-[13px] font-extrabold text-unefa-navy transition hover:bg-slate-200">
                @include('partials.icon', ['name' => 'arrow-left', 'clase' => 'h-4 w-4 text-unefa-navy'])
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection